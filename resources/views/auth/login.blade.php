<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKalinga — Sign In</title>
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

        .auth-card {
            display: flex;
            width: 100%;
            max-width: 820px;
            min-height: 520px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
        }

        /* ── Brand panel ── */
        .brand-panel {
            flex: 1;
            background: linear-gradient(160deg, #0a3d2e 0%, #0f5c42 55%, #1a7a58 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 36px;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -40px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-name {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .logo-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .tagline {
            position: relative;
            z-index: 1;
            margin-top: 40px;
        }

        .tagline h2 {
            font-size: 19px;
            font-weight: 600;
            color: #fff;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .tagline p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.7;
        }

        .badges {
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 20px;
            padding: 7px 14px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.75);
        }

        .badge i {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* ── Form panel ── */
        .form-panel {
            width: 360px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 44px 36px;
        }

        .tab-switcher {
            display: flex;
            background: #f3f4f6;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 28px;
        }

        .tab-btn {
            flex: 1;
            padding: 8px;
            font-size: 13px;
            font-weight: 500;
            font-family: inherit;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            background: transparent;
            color: #6b7280;
            transition: all 0.2s;
        }

        .tab-btn.active {
            background: #fff;
            color: #0f5c42;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        }

        .form-title {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .form-sub {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 5px;
        }

        .input-wrap {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 10px 38px 10px 12px;
            font-size: 14px;
            font-family: inherit;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
            color: #111827;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            border-color: #0f5c42;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15, 92, 66, 0.10);
        }

        .form-input.is-invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.10);
        }

        .input-icon {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #9ca3af;
            pointer-events: none;
        }

        .toggle-pw {
            pointer-events: all;
            cursor: pointer;
        }

        .toggle-pw:hover {
            color: #0f5c42;
        }

        .invalid-feedback {
            font-size: 11px;
            color: #ef4444;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            color: #6b7280;
            cursor: pointer;
        }

        .remember-label input {
            accent-color: #0f5c42;
            width: 14px;
            height: 14px;
        }

        .forgot-link {
            font-size: 12px;
            color: #0f5c42;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 11px;
            font-size: 14px;
            font-family: inherit;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            background: #0f5c42;
            color: #fff;
            cursor: pointer;
            letter-spacing: 0.2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-submit:hover {
            background: #0a3d2e;
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .security-note {
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            align-items: flex-start;
            gap: 9px;
        }

        .security-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #0f5c42;
            flex-shrink: 0;
            margin-top: 4px;
        }

        .security-text {
            font-size: 11px;
            color: #9ca3af;
            line-height: 1.6;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #15803d;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Register form hidden by default */
        #registerForm {
            display: none;
        }

        @media (max-width: 640px) {
            .auth-card {
                flex-direction: column;
            }

            .brand-panel {
                padding: 28px 24px 24px;
            }

            .tagline {
                margin-top: 20px;
            }

            .badges {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .form-panel {
                width: 100%;
                padding: 32px 24px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-card">

        {{-- Brand panel --}}
        <div class="brand-panel">
            <div class="logo">
                <div class="logo-icon">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M11 2C11 2 4 7 4 12.5C4 16.09 7.13 19 11 19C14.87 19 18 16.09 18 12.5C18 7 11 2 11 2Z"
                            fill="rgba(255,255,255,0.9)" />
                        <circle cx="11" cy="12.5" r="2.8" fill="#0f5c42" />
                    </svg>
                </div>
                <div>
                    <div class="logo-name">eKalinga</div>
                    <div class="logo-sub">PLSP Center for Mental Health</div>
                </div>
            </div>

            <div class="tagline">
                <h2>A safer space for student wellbeing records.</h2>
                <p>Paperless. Secure. Always accessible — replacing manual documentation with a centralized digital
                    system.</p>
            </div>

            <div class="badges">
                <span class="badge"><i class="ti ti-lock"></i> Encrypted cloud storage</span>
                <span class="badge"><i class="ti ti-message-circle"></i> Confidential messaging</span>
                <span class="badge"><i class="ti ti-chart-bar"></i> Trend analytics</span>
            </div>
        </div>

        {{-- Form panel --}}
        <div class="form-panel">

            {{-- Tab switcher --}}
            <div class="tab-switcher">
                <button class="tab-btn active" id="loginTab" type="button" onclick="switchTab('login')">Sign In</button>
                <button class="tab-btn" id="registerTab" type="button" onclick="switchTab('register')">Register</button>
            </div>

            {{-- Session / error alerts --}}
            @if (session('status'))
                <div class="alert-success"><i class="ti ti-circle-check"></i> {{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="alert-error"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
            @endif

            {{-- ── LOGIN FORM ── --}}
            <div id="loginFormWrap">
                <p class="form-title">Welcome back</p>
                <p class="form-sub">Sign in to your eKalinga account</p>

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">Email address</label>
                        <div class="input-wrap">
                            <input type="email" id="email" name="email"
                                class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="you@plsp.edu.ph" required autofocus autocomplete="email">
                            <i class="ti ti-mail input-icon"></i>
                        </div>
                        @error('email')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap">
                            <input type="password" id="password" name="password"
                                class="form-input @error('password') is-invalid @enderror" placeholder="••••••••"
                                required autocomplete="current-password">
                            <i class="ti ti-eye input-icon toggle-pw" id="togglePw"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-options">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit" id="loginSubmitBtn">
                        <i class="ti ti-login"></i> Sign in to eKalinga
                    </button>
                </form>
            </div>

            {{-- ── REGISTER FORM ── --}}
            <div id="registerForm">
                <p class="form-title">Create account</p>
                <p class="form-sub">Register as a student of PLSP</p>

                <form method="POST" action="{{ route('register') }}" id="regForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="reg_name">Full name</label>
                        <div class="input-wrap">
                            <input type="text" id="reg_name" name="name"
                                class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Juan dela Cruz" required autocomplete="name">
                            <i class="ti ti-user input-icon"></i>
                        </div>
                        @error('name')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_email">Email address</label>
                        <div class="input-wrap">
                            <input type="email" id="reg_email" name="email"
                                class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="you@plsp.edu.ph" required autocomplete="email">
                            <i class="ti ti-mail input-icon"></i>
                        </div>
                        @error('email')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_student_id">Student ID</label>
                        <div class="input-wrap">
                            <input type="text" id="reg_student_id" name="student_id"
                                class="form-input @error('student_id') is-invalid @enderror"
                                value="{{ old('student_id') }}" placeholder="2024-00001" required>
                            <i class="ti ti-id-badge input-icon"></i>
                        </div>
                        @error('student_id')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_program">Program & Section</label>
                        <div class="input-wrap">
                            <input type="text" id="reg_program" name="program_section"
                                class="form-input @error('program_section') is-invalid @enderror"
                                value="{{ old('program_section') }}" placeholder="BSIT - 3A" required>
                            <i class="ti ti-school input-icon"></i>
                        </div>
                        @error('program_section')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_password">Password</label>
                        <div class="input-wrap">
                            <input type="password" id="reg_password" name="password"
                                class="form-input @error('password') is-invalid @enderror"
                                placeholder="At least 8 characters" required autocomplete="new-password">
                            <i class="ti ti-eye input-icon toggle-pw" id="toggleRegPw"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback"><i class="ti ti-alert-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_password_confirm">Confirm password</label>
                        <div class="input-wrap">
                            <input type="password" id="reg_password_confirm" name="password_confirmation"
                                class="form-input" placeholder="••••••••" required autocomplete="new-password">
                            <i class="ti ti-eye input-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="regSubmitBtn">
                        <i class="ti ti-user-plus"></i> Create account
                    </button>
                </form>
            </div>

            <div class="security-note">
                <div class="security-dot"></div>
                <p class="security-text">
                    A 6-digit verification code will be sent to your email after sign in. All sessions are encrypted and
                    logged.
                </p>
            </div>

        </div>
    </div>

    <script>
        // Tab switching
        function switchTab(tab) {
            const loginWrap = document.getElementById('loginFormWrap');
            const regWrap = document.getElementById('registerForm');
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');

            if (tab === 'login') {
                loginWrap.style.display = 'block';
                regWrap.style.display = 'none';
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
            } else {
                loginWrap.style.display = 'none';
                regWrap.style.display = 'block';
                loginTab.classList.remove('active');
                registerTab.classList.add('active');
            }
        }

        // Auto-open register tab if there was a registration error
        @if ($errors->any() && old('_form') === 'register')
            switchTab('register');
        @endif

        // Toggle password (login)
        document.getElementById('togglePw').addEventListener('click', function () {
            const input = document.getElementById('password');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            this.classList.toggle('ti-eye', !isHidden);
            this.classList.toggle('ti-eye-off', isHidden);
        });

        // Toggle password (register)
        document.getElementById('toggleRegPw').addEventListener('click', function () {
            const input = document.getElementById('reg_password');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            this.classList.toggle('ti-eye', !isHidden);
            this.classList.toggle('ti-eye-off', isHidden);
        });

        // Disable submit on click
        function disableOnSubmit(formId, btnId, label) {
            document.getElementById(formId).addEventListener('submit', function () {
                const btn = document.getElementById(btnId);
                btn.disabled = true;
                btn.innerHTML = `<i class="ti ti-loader-2"></i> ${label}`;
            });
        }
        disableOnSubmit('loginForm', 'loginSubmitBtn', 'Signing in...');
        disableOnSubmit('regForm', 'regSubmitBtn', 'Creating account...');
    </script>

</body>

</html>