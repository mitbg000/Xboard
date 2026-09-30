<?php

namespace Plugin\Sepay\Controllers;

use App\Http\Controllers\PluginController;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends PluginController
{
    public function checkout(string $tradeNo): View|RedirectResponse
    {
        $order = Order::where('trade_no', $tradeNo)->firstOrFail();

        if ((int) $order->status !== Order::STATUS_PENDING) {
            return redirect('/#/order/' . $tradeNo);
        }

        $accountNumber = trim((string) $this->getConfig('account_number', ''));
        $accountName = trim((string) $this->getConfig('account_name', ''));
        $bankCode = strtoupper(trim((string) $this->getConfig('bank_code', '')));
        $bankName = trim((string) $this->getConfig('bank_name', ''));
        $contentPrefix = trim((string) $this->getConfig('content_prefix', ''));
        $exchangeRate = (float) $this->getConfig('exchange_rate', 0);

        if ($accountNumber === '' || $accountName === '' || $bankCode === '' || $contentPrefix === '' || $exchangeRate <= 0) {
            abort(422, 'SePay plugin chưa được cấu hình đầy đủ trong payment method config.');
        }

        if ($bankName === '') {
            $bankName = $this->resolveBankName($bankCode);
        }

        $amount = (int) round(($order->total_amount / 100) * $exchangeRate);
        $content = trim($contentPrefix . ' ' . $tradeNo);

        $qrUrl = $this->buildQrUrl($bankCode, $accountNumber, $accountName, $amount, $content);
        $baseUrl = $this->getCanonicalAppUrl();

        return view('Sepay::checkout', [
            'order' => $order,
            'trade_no' => $tradeNo,
            'qr_url' => $qrUrl,
            'bank_code' => $bankCode,
            'bank_name' => $bankName,
            'account_number' => $accountNumber,
            'account_name' => $accountName,
            'amount' => $amount,
            'content' => $content,
            'check_url' => $baseUrl . '/api/v1/guest/sepay/check/' . $tradeNo,
            'return_url' => $baseUrl . '/#/order/' . $tradeNo,
        ]);
    }

    public function check(string $tradeNo): JsonResponse
    {
        $order = Order::where('trade_no', $tradeNo)->first();

        if (!$order) {
            return response()->json([
                'paid' => false,
                'status' => 'not_found',
            ], 404);
        }

        $paid = (int) $order->status !== Order::STATUS_PENDING || !empty($order->paid_at);

        return response()->json([
            'paid' => $paid,
            'status' => $order->status,
            'paid_at' => $order->paid_at,
        ]);
    }

    private function buildQrUrl(string $bankCode, string $accountNumber, string $accountName, int $amount, string $content): string
    {
        $bankCode = trim($bankCode);
        $accountNumber = trim($accountNumber);

        if ($bankCode === '' || $accountNumber === '') {
            return 'https://api.qrserver.com/v1/create-qr-code/?size=320x320&data=' . rawurlencode($content);
        }

        $query = http_build_query([
            'amount' => $amount,
            'addInfo' => $content,
            'accountName' => $accountName,
        ]);

        return sprintf(
            'https://img.vietqr.io/image/%s-%s-compact2.png?%s',
            rawurlencode($bankCode),
            rawurlencode($accountNumber),
            $query
        );
    }

    private function getCanonicalAppUrl(): string
    {
        return rtrim((string) admin_setting('app_url', config('app.url')), '/');
    }

    private function resolveBankName(string $bankCode): string
    {
        $bankNames = [
            'VCB' => 'Vietcombank',
            'ICB' => 'VietinBank',
            'BIDV' => 'BIDV',
            'AGR' => 'Agribank',
            'TCB' => 'Techcombank',
            'MB' => 'MB Bank',
            'ACB' => 'ACB',
            'VPB' => 'VPBank',
            'TPB' => 'TPBank',
            'STB' => 'Sacombank',
            'HDB' => 'HDBank',
            'VIB' => 'VIB',
            'SHB' => 'SHB',
            'EIB' => 'Eximbank',
            'MSB' => 'MSB',
            'LPB' => 'LienVietPostBank',
            'OCB' => 'OCB',
            'ABB' => 'ABBank',
            'NAB' => 'Nam A Bank',
            'SCB' => 'SCB',
            'SEA' => 'SeABank',
            'CAKE' => 'CAKE by VPBank',
            'SHBVN' => 'Shinhan Bank',
            'WOO' => 'Woori Bank',
        ];

        return $bankNames[$bankCode] ?? $bankCode;
    }
}