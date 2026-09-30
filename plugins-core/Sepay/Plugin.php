<?php

namespace Plugin\Sepay;

use App\Models\Plugin as PluginRecord;
use App\Services\Plugin\AbstractPlugin;
use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Log;

class Plugin extends AbstractPlugin implements PaymentInterface
{
    public function install(): void
    {
        $seedConfig = [
            'api_token' => 'abc',
            'content_prefix' => 'SEVQR',
            'account_number' => '1234567890',
            'account_name' => 'Nguyễn Văn A',
            'bank_code' => 'ICB',
            'bank_name' => 'VietinBank',
            'exchange_rate' => 3500,
        ];

        $plugin = PluginRecord::where('code', $this->getPluginCode())->first();
        if ($plugin) {
            $currentConfig = json_decode($plugin->config ?? '[]', true) ?: [];
            $plugin->config = json_encode(array_merge($seedConfig, $currentConfig), JSON_UNESCAPED_UNICODE);
            $plugin->is_enabled = true;
            $plugin->save();
        }
    }

    public function boot(): void
    {
        $this->filter('available_payment_methods', function ($methods) {
            if ($this->getConfig('enabled', true)) {
                $methods['SePay'] = [
                    'name' => $this->getConfig('display_name', 'SePay - Chuyển khoản'),
                    'icon' => $this->getConfig('icon', '🏦'),
                    'plugin_code' => $this->getPluginCode(),
                    'type' => 'plugin'
                ];
            }
            return $methods;
        });
    }

    public function form(): array
    {
        return [];
    }

    public function pay($order): array
    {
        $checkoutUrl = $this->buildAppUrl('/sepay/checkout/' . $order['trade_no']);
        
        return [
            'type' => 1,
            'data' => $checkoutUrl
        ];
    }

    private function buildAppUrl(string $path): string
    {
        $baseUrl = rtrim((string) admin_setting('app_url', config('app.url')), '/');

        return $baseUrl . '/' . ltrim($path, '/');
    }

    public function notify($params): array|bool
    {
        $content = $params['content'] ?? $params['transaction_content'] ?? '';
        
        // Lấy prefix từ config
        $prefix = $this->getConfig('content_prefix', 'SEVQR');
        
        // Parse trade_no từ content "{PREFIX} ABC123"
        $pattern = '/' . preg_quote($prefix, '/') . '\s+([A-Za-z0-9]+)/';
        if (preg_match($pattern, $content, $matches)) {
            $tradeNo = $matches[1];
        } else {
            Log::warning('SePay: Cannot parse trade_no', [
                'content' => $content,
                'prefix' => $prefix,
                'pattern' => $pattern
            ]);
            return false;
        }
        
        // Kiểm tra status
        if (!isset($params['status']) || $params['status'] !== 'success') {
            Log::warning('SePay: Transaction not successful', ['status' => $params['status'] ?? 'unknown']);
            return false;
        }
        
        return [
            'trade_no' => $tradeNo,
            'callback_no' => $params['transaction_id'] ?? $params['id'] ?? uniqid('sepay_')
        ];
    }
}
