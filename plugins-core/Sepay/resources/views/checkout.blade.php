<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh toán đơn hàng #{{ $order->trade_no }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --bg-body: #0a0e1a;
            --bg-card: #1a1f2e;
            --bg-input: #141824;
            --text-main: #ffffff;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --border-color: #2a3042;
            --radius: 16px;
            --success-bg: rgba(16, 185, 129, 0.2);
            --success-text: #34d399;
            --pending-bg: rgba(245, 158, 11, 0.2);
            --pending-text: #fbbf24;
            --error-bg: rgba(239, 68, 68, 0.2);
            --error-text: #f87171;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 40px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        h1 {
            color: var(--text-main);
            margin-bottom: 8px;
            font-size: 22px;
            text-align: center;
            font-weight: 700;
        }

        .trade-no {
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .trade-no strong { color: var(--primary); font-weight: 600; }

        .qr-container {
            text-align: center;
            margin: 24px 0;
            background: #fff;
            padding: 16px;
            border-radius: 12px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .qr-container img {
            max-width: 100%;
            width: 240px;
            height: auto;
            display: block;
        }

        .info {
            background: var(--bg-input);
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            border: 1px solid var(--border-color);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row:last-child { border-bottom: none; }

        .label { color: var(--text-secondary); font-size: 14px; }

        .value {
            font-weight: 600;
            color: var(--text-main);
            font-size: 14px;
            text-align: right;
        }

        .amount-highlight { color: var(--primary); font-size: 18px; }

        .instructions {
            background: rgba(59, 130, 246, 0.1);
            padding: 16px;
            border-radius: 12px;
            margin-top: 20px;
            font-size: 13px;
            color: var(--text-secondary);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .instructions strong {
            color: var(--primary);
            display: block;
            margin-bottom: 8px;
        }

        .instructions ol { margin: 0 0 0 20px; }
        .instructions li { margin: 4px 0; }

        #status-area { margin-top: 24px; }

        .confirm-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .confirm-btn:hover { background: var(--primary-hover); transform: translateY(-2px); }
        .confirm-btn:active { transform: translateY(0); }
        .confirm-btn:disabled { background: var(--text-muted); cursor: not-allowed; transform: none; box-shadow: none; opacity: 0.7; }

        .status {
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            margin-top: 16px;
            font-weight: 500;
            font-size: 14px;
            display: none;
        }

        .status.pending { background: var(--pending-bg); color: var(--pending-text); border: 1px solid rgba(245, 158, 11, 0.3); }
        .status.success { background: var(--success-bg); color: var(--success-text); border: 1px solid rgba(16, 185, 129, 0.3); }
        .status.error { background: var(--error-bg); color: var(--error-text); border: 1px solid rgba(239, 68, 68, 0.3); }

        @media (max-width: 600px) {
            .container { padding: 24px 20px; }
            h1 { font-size: 20px; }
            .qr-container img { width: 200px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quét mã QR để thanh toán</h1>
        <div class="trade-no">Mã đơn hàng: <strong>#{{ $order->trade_no }}</strong></div>

        <div class="qr-container">
            <img src="{{ $qr_url }}" alt="QR Code Thanh Toán" id="qr-image">
        </div>

        <div class="info">
            <div class="info-row">
                <span class="label">Ngân hàng:</span>
                <span class="value">{{ $bank_name }} ({{ $bank_code }})</span>
            </div>
            <div class="info-row">
                <span class="label">Số tài khoản:</span>
                <span class="value">{{ $account_number }}</span>
            </div>
            <div class="info-row">
                <span class="label">Chủ tài khoản:</span>
                <span class="value">{{ $account_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Số tiền:</span>
                <span class="value amount-highlight">{{ number_format($amount, 0, ',', '.') }} VNĐ</span>
            </div>
            <div class="info-row">
                <span class="label">Nội dung CK:</span>
                <span class="value" style="color: var(--warning);">{{ $content }}</span>
            </div>
        </div>

        <div class="instructions">
            <strong><i class='bx bx-info-circle'></i> Hướng dẫn thanh toán:</strong>
            <ol>
                <li>Mở ứng dụng ngân hàng trên điện thoại</li>
                <li>Quét mã QR ở trên</li>
                <li>Kiểm tra thông tin và xác nhận thanh toán</li>
                <li>Quay lại đây và bấm nút xác nhận bên dưới</li>
            </ol>
        </div>

        <div id="status-area">
            <button id="btn-confirm" class="confirm-btn" onclick="manualCheck()">
                <i class='bx bx-check-circle'></i> Tôi đã thanh toán
            </button>
            <div id="status" class="status"></div>
        </div>
    </div>

    <script>
        const TRADE_NO = @json($trade_no);
        const CHECK_URL = @json($check_url);
        const RETURN_URL = @json($return_url);
        const CHECK_INTERVAL = 15000;
        const MAX_CHECKS = 100;

        let checkInterval = null;
        let checkCount = 0;

        function checkPaymentStatus() {
            checkCount++;

            if (checkCount > MAX_CHECKS) {
                clearInterval(checkInterval);
                return;
            }

            performCheck(true);
        }

        function performCheck(isAuto = false) {
            fetch(CHECK_URL, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.paid) {
                    onPaymentSuccess();
                } else if (!isAuto) {
                    onPaymentPending();
                }
            })
            .catch(error => {
                console.error('Check error:', error);
                if (!isAuto) {
                    const btn = document.getElementById('btn-confirm');
                    btn.disabled = false;
                    btn.innerHTML = "<i class='bx bx-check-circle'></i> Tôi đã thanh toán";
                }
            });
        }

        function onPaymentSuccess() {
            clearInterval(checkInterval);
            const btn = document.getElementById('btn-confirm');
            if (btn) btn.style.display = 'none';

            updateStatus('success', "<i class='bx bx-check-double'></i> Thanh toán thành công! Đang chuyển hướng...");

            setTimeout(() => {
                window.location.href = RETURN_URL;
            }, 2000);
        }

        function onPaymentPending() {
            const btn = document.getElementById('btn-confirm');
            const originalText = "<i class='bx bx-check-circle'></i> Tôi đã thanh toán";

            btn.disabled = false;
            btn.innerHTML = originalText;

            updateStatus('pending', "Chưa nhận được thanh toán. Vui lòng đợi trong giây lát rồi thử lại.");

            setTimeout(() => {
                const statusEl = document.getElementById('status');
                if (statusEl.classList.contains('pending')) {
                    statusEl.style.display = 'none';
                }
            }, 5000);
        }

        function manualCheck() {
            const btn = document.getElementById('btn-confirm');
            btn.disabled = true;
            btn.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Đang kiểm tra...";

            performCheck(false);
        }

        function updateStatus(type, message) {
            const statusEl = document.getElementById('status');
            statusEl.style.display = 'block';
            statusEl.className = 'status ' + type;
            statusEl.innerHTML = message;
        }

        window.addEventListener('DOMContentLoaded', function() {
            checkInterval = setInterval(checkPaymentStatus, CHECK_INTERVAL);
        });

        window.addEventListener('beforeunload', function() {
            if (checkInterval) clearInterval(checkInterval);
        });
    </script>
</body>
</html>