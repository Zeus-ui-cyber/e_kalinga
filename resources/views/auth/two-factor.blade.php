<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKalinga — Verify Your Identity</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .otp-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.10);
            padding: 48px 44px;
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .otp-icon {
            width: 64px;
            height: 64px;
            background: #f0fdf4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 1px solid #bbf7d0;
        }

        .otp-icon i {
            font-size: 28px;
            color: #0f5c42;
        }

        .otp-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 32px;
        }

        .otp-logo-icon {
            width: 30px;
            height: 30px;
            background: #0f5c42;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .otp-logo-name {
            font-size: 16px;
            font-weight: 700;
            color: #0f5c42;
        }

        h1 {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .otp-sub {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .otp-sub strong {
            color: #111827;
        }

        /* 6-box OTP input */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 28px;
        }

        .otp-box {
            width: 48px;
            height: 56px;
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
            color: #111827;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            caret-color: #0f5c42;
        }

        .otp-box:focus {
            border-color: #0f5c42;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15, 92, 66, 0.12);
        }

        .otp-box.is-invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        /* Hidden actual input for form submission */
        #otp_hidden {
            display: none;
        }

        .invalid-feedback {
            font-size: 12px;
            color: #ef4444;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-verify {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            font-family: inherit;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            background: #0f5c42;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s;
            margin-bottom: 20px;
        }

        .btn-verify:hover {
            background: #0a3d2e;
        }

        .btn-verify:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .resend-section {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 24px;
        }

        .resend-section a {
            color: #0f5c42;
            font-weight: 500;
            text-decoration: none;
        }

        .resend-section a:hover {
            text-decoration: underline;
        }

        /* Countdown timer */
        #countdown {
            font-weight: 600;
            color: #0f5c42;
        }

        .back-link {
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .back-link:hover {
            color: #111827;
        }

        .divider {
            height: 1px;
            background: #f0f0f0;
            margin: 20px 0;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #9ca3af;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 5px 12px;
        }
    </style>
</head>

<body>

    <div class="otp-card">

        {{-- Logo --}}
        <div class="otp-logo">
            <div class="otp-logo-icon">
                <svg width="16" height="16" viewBox="0 0 22 22" fill="none">
                    <path d="M11 2C11 2 4 7 4 12.5C4 16.09 7.13 19 11 19C14.87 19 18 16.09 18 12.5C18 7 11 2 11 2Z"
                        fill="rgba(255,255,255,0.95)" />
                    <circle cx="11" cy="12.5" r="2.8" fill="#0f5c42" />
                </svg>
            </div>
            <div class="otp-logo-name">eKalinga</div>
        </div>

        {{-- Icon --}}
        <div class="otp-icon">
            <i class="ti ti-mail-forward"></i>
        </div>

        <h1>Check your email</h1>
        <p class="otp-sub">
            We sent a 6-digit verification code to<br>
            <strong>{{ session('2fa_email', 'your email address') }}</strong>.<br>
            The code expires in <span id="countdown">5:00</span>.
        </p>

        {{-- Errors --}}
        @if (session('error'))
            <div class="alert-error"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
        @endif
        @error('otp')
            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
        @enderror

        {{-- OTP Form --}}
        <form method="POST" action="{{ route('2fa.verify') }}" id="otpForm">
            @csrf

            {{-- 6 visible boxes --}}
            <div class="otp-inputs">
                @for ($i = 1; $i <= 6; $i++)
                    <input type="text" class="otp-box @error('otp') is-invalid @enderror" maxlength="1" inputmode="numeric"
                        pattern="[0-9]" data-index="{{ $i }}" autocomplete="off">
                @endfor
            </div>

            {{-- Hidden input that holds assembled OTP --}}
            <input type="hidden" name="otp" id="otp_hidden">

            <button type="submit" class="btn-verify" id="verifyBtn">
                <i class="ti ti-shield-check"></i> Verify & Continue
            </button>
        </form>

        {{-- Resend --}}
        <div class="resend-section">
            Didn't receive it?
            <form method="POST" action="{{ route('2fa.resend') }}" style="display:inline;" id="resendForm">
                @csrf
                <a href="#" id="resendLink">Resend code</a>
            </form>
        </div>

        <div class="divider"></div>

        <a href="{{ route('login') }}" class="back-link">
            <i class="ti ti-arrow-left"></i> Back to sign in
        </a>

        <div style="margin-top: 20px;">
            <span class="security-badge"><i class="ti ti-lock"></i> Encrypted & secure</span>
        </div>

    </div>

    <script>
        // ── OTP box auto-advance & backspace ──
        const boxes = document.querySelectorAll('.otp-box');
        const hidden = document.getElementById('otp_hidden');

        boxes.forEach((box, idx) => {
            box.addEventListener('input', function () {
                // Allow digits only
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length === 1 && idx < boxes.length - 1) {
                    boxes[idx + 1].focus();
                }
                assembleOtp();
            });

            box.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value && idx > 0) {
                    boxes[idx - 1].focus();
                    boxes[idx - 1].value = '';
                    assembleOtp();
                }
            });

            // Handle paste on first box
            box.addEventListener('paste', function (e) {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                pasted.split('').slice(0, 6).forEach((char, i) => {
                    if (boxes[i]) boxes[i].value = char;
                });
                assembleOtp();
                boxes[Math.min(pasted.length, 5)].focus();
            });
        });

        function assembleOtp() {
            hidden.value = Array.from(boxes).map(b => b.value).join('');
        }

        // Auto-submit when all 6 boxes are filled
        document.getElementById('otpForm').addEventListener('input', function () {
            if (hidden.value.length === 6) {
                setTimeout(() => document.getElementById('otpForm').submit(), 300);
            }
        });

        // Disable verify button on submit
        document.getElementById('otpForm').addEventListener('submit', function () {
            const btn = document.getElementById('verifyBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="ti ti-loader-2"></i> Verifying...';
        });

        // ── Countdown timer (5 minutes) ──
        let timeLeft = 300;
        const countdownEl = document.getElementById('countdown');
        const resendLink = document.getElementById('resendLink');

        function updateCountdown() {
            const m = Math.floor(timeLeft / 60);
            const s = timeLeft % 60;
            countdownEl.textContent = `${m}:${s.toString().padStart(2, '0')}`;
            if (timeLeft <= 0) {
                clearInterval(timer);
                countdownEl.textContent = 'expired';
                countdownEl.style.color = '#ef4444';
                resendLink.style.fontWeight = '700';
            }
            timeLeft--;
        }

        updateCountdown();
        const timer = setInterval(updateCountdown, 1000);

        // ── Resend link ──
        resendLink.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('resendForm').submit();
        });
    </script>

</body>

</html>