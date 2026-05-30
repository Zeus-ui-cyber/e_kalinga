@extends('dashboard.layout')@section('title', 'Request Appointment')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --g1: #0a3d1f;
            --g2: #145c32;
            --g3: #1e8449;
            --g4: #27ae60;
            --g5: #52c47a;
            --g6: #a8e6bc;
            --g7: #d4f5e2;
            --g8: #edfaf3;
            --gborder: #82c9a0;
            --text-head: #062310;
            --text-body: #1a4a2c;
            --text-soft: #4a8c62;
            --text-muted: #89b89a;
            --danger: #c0392b;
            --warn-bg: #fef5ec;
            --warn-border: #f0a355;
            --warn-text: #7a3e00;
            --info-bg: #eaf4fd;
            --info-border: #6db8e8;
            --info-text: #0d3d66;
            --white: #ffffff;
            --radius-sm: 8px;
            --radius: 14px;
            --radius-lg: 20px;
            --shadow-sm: 0 1px 4px rgba(10, 61, 31, 0.07);
            --shadow: 0 4px 24px rgba(10, 61, 31, 0.10);
            --shadow-lg: 0 12px 40px rgba(10, 61, 31, 0.16);
            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .appt-page {
            font-family: 'DM Sans', sans-serif;
            background: var(--g8);
            min-height: calc(100vh - 120px);
            padding: 1rem 0 2rem;
            position: relative;
        }

        .appt-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(22px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .appt-page-header {
            margin-bottom: 1.75rem;
        }

        .appt-breadcrumb {
            font-size: 12px;
            color: var(--text-soft);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .appt-breadcrumb a {
            color: var(--g3);
            text-decoration: none;
            font-weight: 500;
        }

        .appt-breadcrumb .sep { color: var(--text-muted); }
        .appt-page-title { display: flex; align-items: center; gap: 14px; margin-bottom: 6px; }
        .title-icon-wrap { position: relative; flex-shrink: 0; }
        .title-icon { width: 52px; height: 52px; border-radius: 15px; background: linear-gradient(135deg, var(--g1) 0%, var(--g3) 100%); display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 6px 20px rgba(10, 61, 31, 0.28); }
        .title-text h1 { font-family: 'DM Serif Display', serif; font-size: 24px; color: var(--text-head); line-height: 1.2; }
        .title-text p { font-size: 13px; color: var(--text-soft); margin-top: 3px; }

        .appt-notice { background: var(--info-bg); border: 1px solid var(--info-border); border-left: 4px solid #2980b9; border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 1.75rem; font-size: 12.5px; color: var(--info-text); display: flex; align-items: flex-start; gap: 10px; }
        .appt-notice i { font-size: 16px; margin-top: 1px; flex-shrink: 0; }

        .appt-card { background: var(--white); border: 1px solid var(--gborder); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); overflow: hidden; }
        .appt-card-header { background: linear-gradient(135deg, var(--g1) 0%, var(--g2) 45%, var(--g3) 100%); padding: 1.5rem 1.75rem; color: #fff; }
        .card-header-inner { display: flex; align-items: center; gap: 14px; }
        .card-header-icon { width: 46px; height: 46px; border-radius: 12px; background: rgba(255, 255, 255, 0.15); display: flex; align-items: center; justify-content: center; font-size: 22px; border: 1.5px solid rgba(255, 255, 255, 0.2); }
        .card-header-text h2 { font-family: 'DM Serif Display', serif; font-size: 18px; font-weight: 400; margin: 0; }
        .card-header-text p { font-size: 12px; margin: 3px 0 0; opacity: 0.75; }

        .form-progress { display: flex; gap: 0; padding: 0 1.75rem; background: var(--g8); border-bottom: 1px solid var(--g7); overflow-x: auto; }
        .progress-step { display: flex; align-items: center; gap: 7px; padding: 12px 14px 12px 0; font-size: 11.5px; font-weight: 600; color: var(--text-muted); white-space: nowrap; }
        .progress-step:not(:last-child)::after { content: '›'; margin-left: 10px; color: var(--g6); font-size: 14px; }
        .progress-step.active { color: var(--g3); }
        .progress-step .step-num { width: 20px; height: 20px; border-radius: 50%; background: var(--g7); color: var(--text-soft); font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .progress-step.active .step-num { background: var(--g3); color: #fff; box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2); }

        .appt-card-body { padding: 1.75rem; }
        .form-section { margin-bottom: 2rem; }
        .form-section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--g2); margin-bottom: 1.1rem; padding-bottom: 8px; border-bottom: 2px solid var(--g7); display: flex; align-items: center; gap: 8px; }
        .section-title-icon { width: 26px; height: 26px; border-radius: 7px; background: var(--g7); display: flex; align-items: center; justify-content: center; font-size: 13px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-grid.cols-1 { grid-template-columns: 1fr; }
        @media(max-width:580px) { .form-grid { grid-template-columns: 1fr; } }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        label { font-size: 12px; font-weight: 600; color: var(--text-body); display: flex; align-items: center; gap: 4px; }
        label .req { color: var(--danger); font-size: 14px; line-height: 1; }

        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid var(--g6); border-radius: var(--radius-sm); font-size: 13.5px; color: var(--text-head); background: #fff; transition: border-color var(--transition), box-shadow var(--transition); }
        .form-control:hover { border-color: var(--g4); background: var(--g8); }
        .form-control:focus { outline: none; border-color: var(--g3); background: #fff; box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.14); }
        textarea.form-control { resize: vertical; min-height: 110px; line-height: 1.6; }
        select.form-control { cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%234a8c62' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }

        .field-hint { font-size: 11px; color: var(--text-muted); }
        .field-error { font-size: 11px; color: var(--danger); display: flex; align-items: center; gap: 3px; }
        .concern-wrap { position: relative; }
        .char-count { position: absolute; bottom: 10px; right: 12px; font-size: 10px; color: var(--text-muted); }

        .urgency-options { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        @media(max-width:480px) { .urgency-options { grid-template-columns: 1fr; } }
        .urgency-option input[type=radio] { display: none; }
        .urgency-option label { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 16px 10px; border: 2px solid var(--g7); border-radius: var(--radius); cursor: pointer; text-align: center; transition: all var(--transition); background: var(--g8); }
        .urgency-option label:hover { border-color: var(--g4); transform: translateY(-2px); box-shadow: var(--shadow); }
        .urgency-icon { font-size: 28px; }
        .urgency-name { font-size: 12.5px; font-weight: 700; color: var(--text-head); }
        .urgency-desc { font-size: 10.5px; color: var(--text-soft); }

        .urgency-option.low input:checked+label { border-color: var(--g3); background: var(--g7); box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.15), var(--shadow); }
        .urgency-option.moderate input:checked+label { border-color: #d68910; background: #fef5ec; box-shadow: 0 0 0 4px rgba(214, 137, 16, 0.15), var(--shadow); }
        .urgency-option.urgent input:checked+label { border-color: var(--danger); background: #fdf0ee; box-shadow: 0 0 0 4px rgba(192, 57, 43, 0.15), var(--shadow); }

        .privacy-check { display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; background: linear-gradient(135deg, var(--g8), var(--g7)); border: 1.5px solid var(--gborder); border-radius: var(--radius-sm); }
        .privacy-check input[type=checkbox] { width: 17px; height: 17px; margin-top: 2px; accent-color: var(--g3); cursor: pointer; }
        .privacy-check label { font-size: 12px; color: var(--text-body); line-height: 1.55; }
        .privacy-lock { font-size: 22px; flex-shrink: 0; align-self: center; }
        .form-divider { border: none; border-top: 1.5px dashed var(--g7); margin: 1.75rem 0; }

        .appt-submit-bar { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding-top: 1.25rem; border-top: 1.5px solid var(--g7); margin-top: 1.5rem; flex-wrap: wrap; }
        .submit-info { font-size: 11px; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }
        .submit-actions { display: flex; gap: 10px; align-items: center; }
        .btn-cancel { padding: 10px 20px; border-radius: var(--radius-sm); border: 1.5px solid var(--g6); background: transparent; color: var(--text-soft); font-size: 13px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-submit { padding: 11px 28px; border-radius: var(--radius-sm); border: none; background: linear-gradient(135deg, var(--g1) 0%, var(--g3) 100%); color: #fff; font-size: 13.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(10, 61, 31, 0.30); position: relative; overflow: hidden; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(10, 61, 31, 0.35); }

        .btn-submit .spinner { display: none; position: absolute; width: 18px; height: 18px; border: 2px solid rgba(255, 255, 255, 0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.7s linear infinite; }
        .btn-submit.loading .spinner { display: block; }
        .btn-submit.loading .btn-label { opacity: 0; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .alert-error { background: #fdf0ee; border: 1px solid #e8a49b; border-left: 4px solid var(--danger); padding: 12px 16px; margin-bottom: 1.25rem; font-size: 13px; color: #7a1c11; }
    </style>
@endsection

@section('content')
    <div class="appt-page">
        <div class="appt-container">

            {{-- Breadcrumb & Header --}}
            <div class="appt-page-header">
                <div class="appt-breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <span class="sep">›</span>
                    <a href="{{ route('appointments.index') }}">Appointments</a>
                    <span class="sep">›</span>
                    <span>New Request</span>
                </div>
                <div class="appt-page-title">
                    <div class="title-icon-wrap">
                        <div class="title-icon">🧠</div>
                    </div>
                    <div class="title-text">
                        <h1>Request Counseling</h1>
                        <p>Fill out the form below to schedule a mental health support session.</p>
                    </div>
                </div>
            </div>

            {{-- Info notice --}}
            <div class="appt-notice">
                <i class="ti ti-shield-lock"></i>
                <span>All information you provide is <strong>strictly confidential</strong> and will only be accessed by authorized counselors. Your privacy is our highest priority.</span>
            </div>

            {{-- Card --}}
            <div class="appt-card">
                <div class="appt-card-header">
                    <div class="card-header-inner">
                        <div class="card-header-icon">📋</div>
                        <div class="card-header-text">
                            <h2>Appointment Request Form</h2>
                            <p>Fields marked with <strong style="color:#c6f5d9">*</strong> are required · Est. 3 min to complete</p>
                        </div>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="form-progress">
                    <div class="progress-step active"><span class="step-num">1</span> Personal Info</div>
                    <div class="progress-step active"><span class="step-num">2</span> Concern</div>
                    <div class="progress-step active"><span class="step-num">3</span> Schedule</div>
                    <div class="progress-step active"><span class="step-num">4</span> Urgency</div>
                </div>

                {{-- Body --}}
                <div class="appt-card-body">
                    @if ($errors->any())
                        <div class="alert-error">
                            ⚠ Please fix the following: {{ implode(', ', $errors->all()) }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('appointments.store') }}" id="appt-form">
                        @csrf

                        {{-- ── 1. Personal Information ── --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <span class="section-title-icon">👤</span> Personal Information
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Full Name <span class="req">*</span></label>
                                    <input type="text" name="full_name" class="form-control" placeholder="e.g. Juan Dela Cruz" value="{{ old('full_name', auth()->user()->name) }}" required />
                                    @error('full_name')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Student ID <span class="req">*</span></label>
                                    <input type="text" name="student_id" class="form-control" placeholder="e.g. 2021-00123" value="{{ old('student_id') }}" required />
                                    @error('student_id')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Course <span class="req">*</span></label>
                                    <select name="course" class="form-control" required>
                                        <option value="">— Select course —</option>
                                        @foreach(['BSIT', 'BSCS', 'BSN', 'BSEd', 'BSED', 'BSBA', 'BSCRIM', 'BSA', 'BSME', 'BSCE', 'Others'] as $c)
                                            <option value="{{ $c }}" {{ old('course') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                        @endforeach
                                    </select>
                                    @error('course')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Year Level <span class="req">*</span></label>
                                    <select name="year_level" class="form-control" required>
                                        <option value="">— Select year —</option>
                                        @foreach(['1st Year', '2nd Year', '3rd Year', '4th Year', '5th Year', 'Graduate'] as $y)
                                            <option value="{{ $y }}" {{ old('year_level') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                    @error('year_level')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Contact Number <span class="req">*</span></label>
                                    <input type="text" name="contact_number" class="form-control" placeholder="09XX XXX XXXX" value="{{ old('contact_number') }}" required />
                                    @error('contact_number')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Email Address <span class="req">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="yourname@school.edu.ph" value="{{ old('email', auth()->user()->email) }}" required />
                                    @error('email')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <hr class="form-divider" />

                        {{-- ── 2. Concern ── --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <span class="section-title-icon">💬</span> Concern / Reason for Consultation
                            </div>
                            <div class="form-grid cols-1">
                                <div class="form-group">
                                    <label>Briefly describe your concern <span class="req">*</span></label>
                                    <div class="concern-wrap">
                                        <textarea name="concern" id="concern-textarea" class="form-control" rows="5" maxlength="1000" placeholder="Please describe what you're going through. Everything shared here is strictly confidential." required>{{ old('concern') }}</textarea>
                                        <span class="char-count" id="char-count">0 / 1000</span>
                                    </div>
                                    <span class="field-hint">Minimum 20 characters. Be as specific as you feel comfortable.</span>
                                    @error('concern')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <hr class="form-divider" />

                        {{-- ── 3. Schedule ── --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <span class="section-title-icon">📅</span> Preferred Schedule
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Preferred Date <span class="req">*</span></label>
                                    <input type="date" name="preferred_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('preferred_date') }}" required />
                                    <span class="field-hint">Must be at least 1 day from today.</span>
                                    @error('preferred_date')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Preferred Time Slot <span class="req">*</span></label>
                                    <select name="preferred_time" class="form-control" required>
                                        <option value="">— Select time slot —</option>
                                        @foreach(['08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM'] as $t)
                                            <option value="{{ $t }}" {{ old('preferred_time') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                        @endforeach
                                    </select>
                                    @error('preferred_time')<span class="field-error">⚠ {{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <hr class="form-divider" />

                        {{-- ── 4. Urgency ── --}}
                        <div class="form-section">
                            <div class="form-section-title">
                                <span class="section-title-icon">⚡</span> Urgency Level
                            </div>
                            <div class="urgency-options">
                                <div class="urgency-option low">
                                    <input type="radio" name="urgency_level" id="urg-low" value="low" {{ old('urgency_level', 'low') === 'low' ? 'checked' : '' }} />
                                    <label for="urg-low">
                                        <span class="urgency-icon">🟢</span>
                                        <span class="urgency-name">Low</span>
                                        <span class="urgency-desc">General wellness check</span>
                                    </label>
                                </div>
                                <div class="urgency-option moderate">
                                    <input type="radio" name="urgency_level" id="urg-mod" value="moderate" {{ old('urgency_level') === 'moderate' ? 'checked' : '' }} />
                                    <label for="urg-mod">
                                        <span class="urgency-icon">🟡</span>
                                        <span class="urgency-name">Moderate</span>
                                        <span class="urgency-desc">Needs attention soon</span>
                                    </label>
                                </div>
                                <div class="urgency-option urgent">
                                    <input type="radio" name="urgency_level" id="urg-high" value="urgent" {{ old('urgency_level') === 'urgent' ? 'checked' : '' }} />
                                    <label for="urg-high">
                                        <span class="urgency-icon">🔴</span>
                                        <span class="urgency-name">Urgent</span>
                                        <span class="urgency-desc">Requires immediate help</span>
                                    </label>
                                </div>
                            </div>
                            @error('urgency_level')<span class="field-error" style="margin-top:8px">⚠ {{ $message }}</span>@enderror
                        </div>

                        <hr class="form-divider" />

                        {{-- ── Privacy ── --}}
                        <div class="privacy-check">
                            <span class="privacy-lock">🔒</span>
                            <input type="checkbox" id="privacy" name="privacy_agreed" value="1" {{ old('privacy_agreed') ? 'checked' : '' }} required />
                            <label for="privacy">
                                I understand that the information I provide will be kept <strong>strictly confidential</strong> and will only be shared with authorized counselors of the E-Kalinga Mental Health Advocacy System. I consent to be contacted via the messaging system for follow-up.
                            </label>
                        </div>
                        @error('privacy_agreed')<span class="field-error" style="margin-top:6px">⚠ {{ $message }}</span>@enderror

                        {{-- ── Submit ── --}}
                        <div class="appt-submit-bar">
                            <span class="submit-info">
                                <i class="ti ti-lock" style="font-size:12px"></i> Your data is encrypted and confidential
                            </span>
                            <div class="submit-actions">
                                <a href="{{ route('appointments.index') }}" class="btn-cancel">
                                    <i class="ti ti-x" style="font-size:12px"></i> Cancel
                                </a>
                                <button type="submit" class="btn-submit" id="submit-btn">
                                    <div class="spinner"></div>
                                    <span class="btn-label"><i class="ti ti-send"></i> Submit Request</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Character counter
        const textarea = document.getElementById('concern-textarea');
        const counter = document.getElementById('char-count');
        if (textarea && counter) {
            const update = () => {
                const len = textarea.value.length;
                counter.textContent = len + ' / 1000';
                counter.className = 'char-count' + (len > 900 ? ' danger' : len > 750 ? ' warn' : '');
            };
            textarea.addEventListener('input', update);
            update();
        }

        // Submit button loading state
        const form = document.getElementById('appt-form');
        const submitBtn = document.getElementById('submit-btn');
        if (form && submitBtn) {
            form.addEventListener('submit', () => {
                submitBtn.classList.add('loading');
                submitBtn.querySelector('.btn-label').innerHTML = 'Submitting…';
            });
        }
    </script>
@endsection