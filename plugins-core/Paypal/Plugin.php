<?php

namespace Plugin\Paypal;

use App\Services\Plugin\AbstractPlugin;
use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Plugin extends AbstractPlugin implements PaymentInterface
{
    public function boot(): void
    {
        $this->filter('available_payment_methods', function ($methods) {
            if ($this->getConfig('enabled', true)) {
                $methods['PayPal'] = [
                    'name' => 'PayPal',
                    'icon' => '💳',
                    'plugin_code' => $this->getPluginCode(),
                    'type' => 'plugin'
                ];
            }
            return $methods;
        });
    }

    public function form(): array
    {
        return [
            'mode' => [
                'label' => 'Môi trường (Mode)',
                'type' => 'string',
                'description' => 'Nhập chữ "sandbox" để thử nghiệm, hoặc "live" để chạy thật',
                'required' => true,
                'default' => 'sandbox'
            ],
            'client_id' => [
                'label' => 'Client ID',
                'type' => 'string',
                'description' => 'Client ID từ tài khoản PayPal Developer của bạn',
                'required' => true
            ],
            'client_secret' => [
                'label' => 'Client Secret',
                'type' => 'string',
                'description' => 'Client Secret từ tài khoản PayPal Developer của bạn',
                'required' => true
            ],
            'currency' => [
                'label' => 'Đơn vị tiền tệ',
                'type' => 'string',
                'description' => 'Mã tiền tệ (Ví dụ: USD, EUR, GBP). Do PayPal không hỗ trợ trực tiếp VND, bạn phải dùng ngoại tệ.',
                'default' => 'USD',
                'required' => true
            ],
            'exchange_rate' => [
                'label' => 'Tỷ giá hối đoái (VND sang Ngoại tệ)',
                'type' => 'string',
                'description' => 'Nếu hệ thống web Xboard bạn dùng VND, nhập tỷ giá quy đổi sang ngoại tệ. (VD: Nhập 25000 để 1 USD = 25000 VND). Nếu Web bạn đã dùng USD ở sẵn thì nhập 1.',
                'default' => '25000',
                'required' => true
            ]
        ];
    }

    private function getApiUrl(): string
    {
        return $this->getConfig('mode') === 'live' 
            ? 'https://api-m.paypal.com' 
            : 'https://api-m.sandbox.paypal.com';
    }

    public function pay($order): array
    {
        $client_id = $this->getConfig('client_id');
        $client_secret = $this->getConfig('client_secret');
        $currency = $this->getConfig('currency', 'USD');
        $exchange_rate = (float) $this->getConfig('exchange_rate', 25000);

        if ($exchange_rate <= 0) $exchange_rate = 1;

        // XBoard lưu tổng tiền ở định dạng cents (tức là x100)
        // VD: 100000 trong DB là 1000.00
        $totalAmount = $order['total_amount'] / 100;
        $paypalValue = round($totalAmount / $exchange_rate, 2);

        // Lấy dánh quyền Token API PayPal
        $response = Http::asForm()->withBasicAuth($client_id, $client_secret)
            ->post($this->getApiUrl() . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        if (!$response->successful()) {
            Log::error('PayPal Auth Failed', ['response' => $response->json()]);
            throw new \Exception('Không thể xác thực API với PayPal. Vui lòng kiểm tra Client ID/Secret.');
        }

        $token = $response->json('access_token');

        // Tạo order
        // Chúng ta lừa PayPal redirect vào notify_url để xác nhận đơn hàng phía người dùng khi thanh toán xong mà ko cần set up webhook phức tạp.
        $orderResponse = Http::withToken($token)
            ->post($this->getApiUrl() . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => (string) $order['trade_no'],
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => number_format($paypalValue, 2, '.', '')
                        ]
                    ]
                ],
                'application_context' => [
                    'return_url' => $order['notify_url'] . '?action=approve',
                    'cancel_url' => $order['return_url'], // Quay lại trang User nếu hủy
                    'user_action' => 'PAY_NOW'
                ]
            ]);

        if (!$orderResponse->successful()) {
            Log::error('PayPal Create Order Failed', ['response' => $orderResponse->json()]);
            throw new \Exception('Lỗi tạo đơn hàng thanh toán qua PayPal.');
        }

        $links = $orderResponse->json('links');
        $approveLink = null;
        foreach ($links as $link) {
            if ($link['rel'] === 'approve') {
                $approveLink = $link['href'];
                break;
            }
        }

        if (!$approveLink) {
            throw new \Exception('PayPal API không trả thông tin link thanh toán.');
        }

        return [
            'type' => 1, // Loại trả về 1 đồng nghĩa Xboard sẽ redirect user sang Approve Link
            'data' => $approveLink
        ];
    }

    public function notify($params): array|bool
    {
        $client_id = $this->getConfig('client_id');
        $client_secret = $this->getConfig('client_secret');

        // Khi người dùng thanh toán xong và được PayPal redirect lại trang notify_url
        if (isset($params['token']) && isset($params['action']) && $params['action'] === 'approve') {
            $orderToken = $params['token'];

            $response = Http::asForm()->withBasicAuth($client_id, $client_secret)
                ->post($this->getApiUrl() . '/v1/oauth2/token', [
                    'grant_type' => 'client_credentials'
                ]);

            if (!$response->successful()) {
                Log::error('PayPal Notify Auth Failed', ['response' => $response->json()]);
                echo "<h3>Lỗi Auth Token PayPal Notify:</h3><pre>" . json_encode($response->json(), JSON_PRETTY_PRINT) . "</pre>";
                exit;
            }

            $accessToken = $response->json('access_token');

            // Đảm bảo gửi payload là object {} cho PayPal API
            $captureResponse = Http::withToken($accessToken)
                ->withBody('{}', 'application/json')
                ->post($this->getApiUrl() . "/v2/checkout/orders/{$orderToken}/capture");

            $body = $captureResponse->json();
            Log::info("PayPal Capture Response", ['body' => $body]);

            // Ghi nhận lỗi ra màn hình để bắt bệnh nếu Sandbox bị từ chối
            if (!$captureResponse->successful() && !(isset($body['name']) && $body['name'] === 'UNPROCESSABLE_ENTITY')) {
                echo "<div style='padding: 20px; font-family: monospace;'><h3>Lỗi Thu Tiền PayPal:</h3><p>Mã lỗi HTTP: " . $captureResponse->status() . "</p><pre>" . json_encode($body, JSON_PRETTY_PRINT) . "</pre></div>";
                exit;
            }

            // Nếu thu tiền thành công hoặc đang pending
            if ($captureResponse->successful() && isset($body['status']) && in_array($body['status'], ['COMPLETED', 'PENDING'])) {
                $tradeNo = $body['purchase_units'][0]['reference_id'] ?? null;
                if (!$tradeNo) return false;

                // Báo cho Xboard tự động chuyển người dùng về trang Đơn Hàng thay vì kẹt ở chữ "success"
                $returnUrl = url('/#/order/' . $tradeNo);
                
                return [
                    'trade_no' => $tradeNo,
                    'callback_no' => $body['id'] ?? $orderToken,
                    'custom_result' => redirect()->to($returnUrl) // Yêu cầu Laravel bắn 302 Redirect
                ];
            }
            
            // Xử lý trường hợp đã bắt tiền trước đó
            if (isset($body['name']) && $body['name'] === 'UNPROCESSABLE_ENTITY' && strpos(json_encode($body), 'ORDER_ALREADY_CAPTURED') !== false) {
                 $detailsResponse = Http::withToken($accessToken)
                    ->get($this->getApiUrl() . "/v2/checkout/orders/{$orderToken}");
                    
                 $details = $detailsResponse->json();
                 
                 if (isset($details['status']) && $details['status'] === 'COMPLETED' && isset($details['purchase_units'][0]['reference_id'])) {
                     $tradeNo = $details['purchase_units'][0]['reference_id'];
                     $returnUrl = url('/#/order/' . $tradeNo);
                     
                     return [
                         'trade_no' => $tradeNo,
                         'callback_no' => $orderToken,
                         'custom_result' => redirect()->to($returnUrl)
                     ];
                 }
            }
        }

        // Catch the native webhook context if setup externally via console
        if (isset($params['event_type']) && $params['event_type'] === 'PAYMENT.CAPTURE.COMPLETED') {
            $resource = $params['resource'] ?? [];
            if (isset($resource['supplementary_data']['related_ids']['order_id'])) {
                $tradeNo = $resource['custom_id'] ?? null; // Cần verify...
            }
        }

        return false;
    }
}
