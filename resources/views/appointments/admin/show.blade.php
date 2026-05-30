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

        /* ── Back link ── */
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

        /* ── Detail card ── */
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

        .detail-card-header-left h2 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-card-header-left p {
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

        .detail-field {}

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

        /* divider */
        .detail-divider {
            border: none;
            border-top: 1.5px dashed var(--warm);
            margin: 20px 0;
        }

        /* ── Action panel ── */
        .action-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .action-card-header {
            background: var(--cream);
            border-bottom: 1px solid var(--warm);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            color: var(--dusk);
        }

        .action-card-header i {
            font-size: 17px;
            color: var(--sage);
        }

        .action-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* status buttons */
        .status-row-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .status-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .status-btn {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            border: 1.5px solid;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: transform .15s, box-shadow .15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-btn i {
            font-size: 13px;
        }

        .status-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        }

        .status-btn:disabled,
        .status-btn.active {
            opacity: .45;
            cursor: default;
            pointer-events: none;
            transform: none;
        }

        .sb-processing {
            background: var(--sky-pale);
            color: #1e4f6e;
            border-color: #93c5de;
        }

        .sb-confirmed {
            background: #e8f5e9;
            color: #2e7d32;
            border-color: #a5d6a7;
        }

        .sb-completed {
            background: var(--sage-pale);
            color: var(--dusk);
            border-color: var(--sage-light);
        }

        .sb-cancelled {
            background: #ffebee;
            color: #b71c1c;
            border-color: #ef9a9a;
        }

        /* ── Schedule form ── */
        .schedule-panel {
            background: #f5f0fe;
            border: 1px solid #d1c4e9;
            border-radius: var(--radius-sm);
            padding: 18px;
        }

        .schedule-panel h4 {
            font-size: 13px;
            font-weight: 700;
            color: #4527a0;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .schedule-panel h4 i {
            font-size: 15px;
        }

        .sched-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media(max-width:500px) {
            .sched-grid {
                grid-template-columns: 1fr;
            }
        }

        .sched-grid .full {
            grid-column: 1 / -1;
        }

        .sched-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .sched-field label {
            font-size: 11px;
            font-weight: 700;
            color: #5b2d8e;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .sched-field input,
        .sched-field select,
        .sched-field textarea {
            padding: 9px 12px;
            border: 1.5px solid #c5b3e6;
            border-radius: var(--radius-sm);
            font-size: 13px;
            color: var(--dusk);
            background: #fff;
            font-family: inherit;
            transition: border-color .15s, box-shadow .15s;
        }

        .sched-field input:focus,
        .sched-field select:focus,
        .sched-field textarea:focus {
            outline: none;
            border-color: #7c4dff;
            box-shadow: 0 0 0 3px rgba(124, 77, 255, .12);
        }

        .sched-field textarea {
            resize: vertical;
            min-height: 72px;
        }

        .btn-schedule {
            margin-top: 14px;
            padding: 9px 22px;
            background: #7c4dff;
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-family: inherit;
            transition: background .15s, transform .15s;
        }

        .btn-schedule:hover {
            background: #651fff;
            transform: translateY(-1px);
        }

        .btn-schedule i {
            font-size: 14px;
        }

        /* existing schedule display */
        .existing-schedule {
            background: #ede7f6;
            border: 1px solid #c5b3e6;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            margin-bottom: 14px;
        }

        .existing-schedule h5 {
            font-size: 12px;
            font-weight: 700;
            color: #4527a0;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .existing-schedule h5 i {
            font-size: 14px;
        }

        .es-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .es-item label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #7c4dff;
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }

        .es-item span {
            font-size: 13px;
            color: #1a0535;
            font-weight: 500;
        }

        /* ── Message form ── */
        .msg-panel {
            background: var(--cream);
            border: 1px solid var(--warm);
            border-radius: var(--radius-sm);
            padding: 18px;
        }

        .msg-panel h4 {
            font-size: 13px;
            font-weight: 700;
            color: var(--dusk);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .msg-panel h4 i {
            font-size: 15px;
            color: var(--sage);
        }

        .msg-panel textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--warm);
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-family: inherit;
            resize: none;
            color: var(--dusk);
            background: #fff;
            transition: border-color .15s, box-shadow .15s;
        }

        .msg-panel textarea:focus {
            outline: none;
            border-color: var(--sage-light);
            box-shadow: 0 0 0 3px rgba(92, 122, 110, .1);
        }

        .btn-send {
            margin-top: 10px;
            padding: 9px 22px;
            background: linear-gradient(135deg, var(--dusk), var(--sage));
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-family: inherit;
            transition: opacity .15s, transform .15s;
            box-shadow: 0 4px 12px rgba(92, 122, 110, .25);
        }

        .btn-send:hover {
            opacity: .88;
            transform: translateY(-1px);
        }

        .btn-send i {
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="show-wrap">

        {{-- Back --}}
        <a href="{{ route('admin.appointments.index') }}" class="back-link">
            <i class="ti ti-arrow-left"></i> Back to Appointments
        </a>

        {{-- ── Detail card ── --}}
        <div class="detail-card">

            <div class="detail-card-header">
                <div class="detail-card-header-left">
                    <h2>
                        <i class="ti ti-clipboard-list"></i>
                        Appointment #{{ $appointment->id }}
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

            </div>
        </div>

        {{-- ── Admin Actions ── --}}
        <div class="action-card">
            <div class="action-card-header">
                <i class="ti ti-settings"></i> Admin Actions
            </div>
            <div class="action-card-body">

                {{-- Status update --}}
                <div>
                    <div class="status-row-label">Update Status</div>
                    <div class="status-buttons">
                        @foreach([
                                'processing' => ['label' => 'Processing', 'icon' => 'ti-refresh', 'class' => 'sb-processing'],
                                'confirmed' => ['label' => 'Confirmed', 'icon' => 'ti-circle-check', 'class' => 'sb-confirmed'],
                                'completed' => ['label' => 'Completed', 'icon' => 'ti-trophy', 'class' => 'sb-completed'],
                                'cancelled' => ['label' => 'Cancelled', 'icon' => 'ti-x', 'class' => 'sb-cancelled'],
                            ] as $statusVal => $meta)
                            <form method="POST" action="{{ route('admin.appointments.updateStatus', $appointment) }}" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $statusVal }}" />
                                <button type="submit"
                                        class="status-btn {{ $meta['class'] }} {{ $appointment->status === $statusVal ? 'active' : '' }}">
                                        <i class="ti {{ $meta['icon'] }}"></i>
                                        {{ $meta['label'] }}
                                    </button>
                                </form>
                        @endforeach
                    </div>
                </div>

                {{-- Interview schedule --}}
                <div class="schedule-panel">
                    <h4>
                        <i class="ti ti-calendar-event"></i>
                    {{ $appointment->schedule ? 'Update' : 'Set' }} Interview Schedule
                </h4>
                {{-- Existing schedule display --}}
                @if($appointment->schedule)
                    <div class="existing-schedule">
                        <h5><i class="ti ti-calendar-check"></i> Currently Scheduled</h5>
                        <div class="es-grid">
                            <div class="es-item">
                                <label>Date</label>
                                <span>{{ \Carbon\Carbon::parse($appointment->schedule->interview_date)->format('F d, Y') }}</span>
                            </div>
                            <div class="es-item">
                                <label>Time</label>
                                <span>{{ $appointment->schedule->interview_time }}</span>
                            </div>
                            <div class="es-item">
                                <label>Meeting Details</label>
                                <span>{{ $appointment->schedule->meeting_details ?: '—' }}</span>
                            </div>
                            <div class="es-item">
                                    <label>Counselor Notes</label>
                                    <span>{{ $appointment->schedule->counselor_notes ?: '—' }}</span>
                                </div>
                            </div>
                        </div>
                @endif

                    <form method="POST" action="{{ route('admin.appointments.setSchedule', $appointment) }}">
                        @csrf
                     <div class="sched-grid">
                            <div class="sched-field">
                                <label>Interview Date *</label>
                                <input type="date" name="interview_date" required
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ $appointment->schedule?->interview_date }}" />
                            </div>
                        <div class="sched-field">

                                                               <label>Interview Time *</label>
                            <select name="interview_time" required>
                                    <option value="">— Select time —</option>
                                    @foreach(['08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM'] as $t)
                                        <option value="{{ $t }}" {{ $appointment->schedule?->interview_time === $t ? 'selected' : '' }}>
                                            {{ $t }}
                                        </option>
                                    @endforeach
                             </select>
                         </div>
                            <div class="sched-field full">
                                <label>Meeting Details (e.g. Room / Zoom link)</label>
                                <input type="text" name="meeting_details"
                                       placeholder="e.g. Guidance Office Room 101 / https://zoom.us/j/..."
                                 value="{{ $appointment->schedule?->meeting_details }}" />
                            </div>
                            <div class="sched-field full">
                                <label>Counselor Notes (private)</label>
                                <textarea name="counselor_notes" rows="3"
                                          placeholder="Internal notes visible only to counselors…">{{ $appointment->schedule?->counselor_notes }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn-schedule">
                            <i class="ti ti-calendar-plus"></i>
                            {{ $appointment->schedule ? 'Update Schedule' : 'Set Interview Schedule' }}
                        </button>
                    </form>
                </div>

                {{-- Message student --}}
                                <div class="msg-panel">
                    <h4>
                        <i class="ti ti-send"></i>
                  Send Message to {{ $appointment->full_name }}
                    </h4>
    <form method="POST" action="{{ route('messages.send', $appointment->user_id) }}">
                            @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}" />
                        <textarea name="message" rows="3"
                                  placeholder="Type your message to the student regarding their appointment…"></textarea>
                        <button type="submit" class="btn-send">
                            <i class="ti ti-send"></i> Send Message
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection