@extends('dashboard.layout')
@section('title', 'Appointment #' . $appointment->id)
@section('page-title', 'Appointment #' . $appointment->id)

@section('head')
    <style>
        .show-wrap {
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: fadeUp .4s ease both;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--sage);
            text-decoration: none;
            font-weight: 500;
            transition: gap .15s;
        }

        .back-link:hover {
            gap: 10px;
            color: var(--dusk);
        }

        .back-link i {
            font-size: 15px;
        }

        /* ── Main card ── */
        .detail-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .detail-card-header {
            background: linear-gradient(135deg, var(--dusk), var(--sage));
            padding: 20px 24px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .detail-card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-card-header p {
            font-size: 12px;
            opacity: .75;
            margin-top: 4px;
        }

        /* status pills */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-pill::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }

        .pill-pending {
            background: #fff3e0;
            color: #bf360c;
        }

        .pill-pending::before {
            background: #ff7043;
        }

        .pill-processing {
            background: var(--sky-pale);
            color: #1e4f6e;
        }

        .pill-processing::before {
            background: var(--sky);
        }

        .pill-confirmed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .pill-confirmed::before {
            background: #66bb6a;
        }

        .pill-scheduled {
            background: #ede7f6;
            color: #4527a0;
        }

        .pill-scheduled::before {
            background: #9575cd;
        }

        .pill-completed {
            background: var(--sage-pale);
            color: var(--dusk);
        }

        .pill-completed::before {
            background: var(--sage);
        }

        .pill-cancelled {
            background: #ffebee;
            color: #b71c1c;
        }

        .pill-cancelled::before {
            background: #ef5350;
        }

        .detail-body {
            padding: 24px;
        }

        /* ── Section title ── */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--sage);
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1.5px solid var(--warm);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .section-title i {
            font-size: 14px;
        }

        /* ── Detail grid ── */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        @media(max-width:560px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        .detail-field label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--text-muted);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 4px;
        }

        .detail-field label i {
            font-size: 12px;
        }

        .detail-field .val {
            font-size: 14px;
            color: var(--dusk);
            font-weight: 500;
        }

        /* urgency dot */
        .urg-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 4px;
            vertical-align: middle;
        }

        .urg-low {
            background: var(--sage);
        }

        .urg-moderate {
            background: var(--gold);
        }

        .urg-urgent {
            background: #ef5350;
        }

        /* concern box */
        .concern-box {
            background: var(--cream);
            border: 1px solid var(--warm);
            border-left: 3px solid var(--sage-light);
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            padding: 14px 16px;
            font-size: 13px;
            color: var(--text);
            line-height: 1.7;
        }

        .detail-divider {
            border: none;
            border-top: 1.5px dashed var(--warm);
            margin: 20px 0;
        }

        /* ── Interview notice ── */
        .interview-notice {
            background: #ede7f6;
            border: 1px solid #c5b3e6;
            border-left: 3px solid #9575cd;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            padding: 14px 16px;
            margin-top: 20px;
        }

        .interview-notice h4 {
            font-size: 12px;
            font-weight: 700;
            color: #4527a0;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .interview-notice h4 i {
            font-size: 14px;
        }

        .in-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        @media(max-width:480px) {
            .in-grid {
                grid-template-columns: 1fr;
            }
        }

        .in-item label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #7c4dff;
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }

        .in-item span {
            font-size: 13px;
            color: #1a0535;
            font-weight: 500;
        }

        /* ── Confidential notice ── */
        .confidential-notice {
            background: var(--cream);
            border: 1px solid var(--warm);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .confidential-notice i {
            font-size: 15px;
            color: var(--sage);
            flex-shrink: 0;
        }
    </style>
@endsection

@section('content')
    <div class="show-wrap">

        {{-- Back --}}
        <a href="{{ route('appointments.index') }}" class="back-link">
            <i class="ti ti-arrow-left"></i> Back to My Appointments
        </a>

        {{-- Detail card --}}
        <div class="detail-card">

            <div class="detail-card-header">
                <div>
                    <h2>
                        <i class="ti ti-clipboard-list"></i>
                        Counseling Request #{{ $appointment->id }}
                    </h2>
                    <p>Submitted {{ $appointment->created_at->format('F d, Y · g:i A') }}</p>
                </div>
                @php
                    $statusMap = [
                        'pending' => ['label' => 'Pending', 'class' => 'pill-pending'],
                        'processing' => ['label' => 'Processing', 'class' => 'pill-processing'],
                        'confirmed' => ['label' => 'Confirmed', 'class' => 'pill-confirmed'],
                        'interview_scheduled' => ['label' => 'Interview Scheduled', 'class' => 'pill-scheduled'],
                        'completed' => ['label' => 'Completed', 'class' => 'pill-completed'],
                        'cancelled' => ['label' => 'Cancelled', 'class' => 'pill-cancelled'],
                    ];
                    $s = $statusMap[$appointment->status] ?? ['label' => ucfirst($appointment->status), 'class' => 'pill-pending'];
                @endphp
                <span class="status-pill {{ $s['class'] }}">{{ $s['label'] }}</span>
            </div>

            <div class="detail-body">

                {{-- Personal Info --}}
                <div class="section-title">
                    <i class="ti ti-user"></i> Personal Information
                </div>
                <div class="detail-grid">
                    <div class="detail-field">
                        <label><i class="ti ti-user"></i> Full Name</label>
                        <div class="val">{{ $appointment->full_name }}</div>
                    </div>
                    <div class="detail-field">
                        <label><i class="ti ti-id-badge"></i> Student ID</label>
                        <div class="val">{{ $appointment->student_id }}</div>
                    </div>
                    <div class="detail-field">
                        <label><i class="ti ti-school"></i> Course</label>
                        <div class="val">{{ $appointment->course }}</div>
                    </div>
                    <div class="detail-field">
                        <label><i class="ti ti-stairs"></i> Year Level</label>
                        <div class="val">{{ $appointment->year_level }}</div>
                    </div>
                    <div class="detail-field">
                        <label><i class="ti ti-phone"></i> Contact Number</label>
                        <div class="val">{{ $appointment->contact_number }}</div>
                    </div>
                    <div class="detail-field">
                        <label><i class="ti ti-mail"></i> Email Address</label>
                        <div class="val">{{ $appointment->email }}</div>
                    </div>
                </div>

                <hr class="detail-divider" />

                {{-- Schedule --}}
                <div class="section-title">
                    <i class="ti ti-calendar"></i> Preferred Schedule
                </div>
                <div class="detail-grid">
                    <div class="detail-field">
                        <label><i class="ti ti-calendar"></i> Preferred Date</label>
                        <div class="val">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('F d, Y') }}</div>
                    </div>
                    <div class="detail-field">
                        <label><i class="ti ti-clock"></i> Preferred Time</label>
                        <div class="val">{{ $appointment->preferred_time }}</div>
                    </div>
                    <div class="detail-field">
                        <label><i class="ti ti-bolt"></i> Urgency Level</label>
                        <div class="val">
                            <span class="urg-dot urg-{{ $appointment->urgency_level }}"></span>
                            {{ ucfirst($appointment->urgency_level) }}
                        </div>
                    </div>
                </div>

                <hr class="detail-divider" />

                {{-- Concern --}}
                <div class="section-title">
                    <i class="ti ti-message-circle"></i> Concern / Reason for Consultation
                </div>
                <div class="concern-box">{{ $appointment->concern }}</div>

                {{-- Interview schedule (if set) --}}
                @if($appointment->schedule)
                    <div class="interview-notice">
                        <h4><i class="ti ti-calendar-event"></i> Interview Scheduled</h4>
                        <div class="in-grid">
                            <div class="in-item">
                                <label>Date</label>
                                <span>{{ \Carbon\Carbon::parse($appointment->schedule->interview_date)->format('F d, Y') }}</span>
                            </div>
                            <div class="in-item">
                                <label>Time</label>
                                <span>{{ $appointment->schedule->interview_time }}</span>
                            </div>
                            @if($appointment->schedule->meeting_details)
                                <div class="in-item" style="grid-column:1/-1">
                                    <label>Meeting Details</label>
                                    <span>{{ $appointment->schedule->meeting_details }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- Confidential notice --}}
        <div class="confidential-notice">
            <i class="ti ti-lock"></i>
            This information is strictly confidential and only accessible by authorized counselors of the E-Kalinga Mental
            Health Advocacy System.
        </div>

    </div>
@endsection