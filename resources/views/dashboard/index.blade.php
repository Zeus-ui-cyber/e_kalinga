@extends('dashboard.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('head')
    <style>
        /* =========================================================
                   DASHBOARD PAGE STYLES
                ========================================================= */

        .dashboard-header {
            margin-bottom: 28px;
        }

        .dashboard-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--dusk);
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .dashboard-subtitle {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* =========================================================
                   STATS GRID
                ========================================================= */

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #fff;
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: all .2s ease;
            animation: fadeUp .4s ease both;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .stat-card.sage::before {
            background: linear-gradient(90deg, var(--sage), var(--sage-light));
        }

        .stat-card.gold::before {
            background: linear-gradient(90deg, var(--gold), #e8c97a);
        }

        .stat-card.blush::before {
            background: linear-gradient(90deg, var(--blush), #e8c0bb);
        }

        .stat-card.sky::before {
            background: linear-gradient(90deg, var(--sky), #a3c8d8);
        }

        .stat-card.rose::before {
            background: linear-gradient(90deg, #e07b7b, #f0a8a8);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .stat-card-label {
            font-size: 12.5px;
            color: var(--text-muted);
            font-weight: 500;
            line-height: 1.5;
        }

        .stat-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-card-icon i {
            font-size: 22px;
        }

        .stat-card-value {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            font-weight: 700;
            color: var(--dusk);
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-card-sub {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* =========================================================
                   CONTENT GRID
                ========================================================= */

        .content-grid {
            display: grid;
            grid-template-columns: 1.7fr .9fr;
            gap: 18px;
            align-items: start;
        }

        /* =========================================================
                   BUTTONS
                ========================================================= */

        .btn-sm {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 12.5px;
            font-weight: 600;
            transition: .2s ease;
            border: 1.5px solid transparent;
            background: var(--cream);
            color: var(--text-muted);
        }

        .btn-sm i {
            font-size: 16px;
        }

        .btn-sm:hover {
            background: var(--sage-pale);
            color: var(--sage);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--sage), #3d5c50);
            color: #fff !important;
            box-shadow: 0 8px 18px rgba(92, 122, 110, .18);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f6c60, #365147);
            color: #fff !important;
            box-shadow: 0 10px 24px rgba(92, 122, 110, .28);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e07b7b, #c95f5f);
            color: #fff !important;
            box-shadow: 0 8px 18px rgba(224, 123, 123, .18);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--gold), #c9933a);
            color: #fff !important;
        }

        /* =========================================================
                   TABLE
                ========================================================= */

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table thead tr {
            background: #faf7f2;
            border-bottom: 1px solid #efe8de;
        }

        .custom-table thead th {
            padding: 14px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
        }

        .custom-table tbody tr {
            border-bottom: 1px solid #f3ede5;
            transition: .15s ease;
        }

        .custom-table tbody tr:hover {
            background: #fcfaf7;
        }

        .custom-table tbody td {
            padding: 14px 20px;
            font-size: 13px;
            color: var(--text);
        }

        .student-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .student-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky), var(--sage));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .student-name {
            font-weight: 600;
            color: var(--dusk);
        }

        /* =========================================================
                   STATUS BADGES
                ========================================================= */

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .badge-pending {
            background: #fef9ec;
            color: #b7791f;
            border: 1px solid #f5d87a;
        }

        .badge-processing {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #93c5fd;
        }

        .badge-confirmed {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #86efac;
        }

        .badge-interview {
            background: #faf5ff;
            color: #7c3aed;
            border: 1px solid #c4b5fd;
        }

        .badge-completed {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .badge-cancelled {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        .badge-urgent {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        .badge-moderate {
            background: #fef9ec;
            color: #b7791f;
            border: 1px solid #f5d87a;
        }

        .badge-low {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #86efac;
        }

        /* =========================================================
                   EMPTY STATE
                ========================================================= */

        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 30px;
            margin-bottom: 10px;
            display: block;
        }

        .empty-state p {
            font-size: 13px;
        }

        /* =========================================================
                   TREND BARS
                ========================================================= */

        .trend-group {
            margin-bottom: 14px;
        }

        .trend-group:last-child {
            margin-bottom: 0;
        }

        .trend-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .trend-label {
            font-size: 12px;
            color: var(--dusk);
            font-weight: 600;
        }

        .trend-percent {
            font-size: 12px;
            color: var(--text-muted);
        }

        .trend-bar {
            height: 7px;
            background: #f1ece4;
            border-radius: 20px;
            overflow: hidden;
        }

        .trend-fill {
            height: 100%;
            border-radius: 20px;
            background: linear-gradient(90deg, var(--sage), var(--sage-light));
        }

        /* =========================================================
                   NOTIFICATION ITEM
                ========================================================= */

        .notif-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #f3ede5;
        }

        .notif-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .notif-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--sage);
            flex-shrink: 0;
            margin-top: 5px;
        }

        .notif-text {
            font-size: 12.5px;
            color: var(--text);
            line-height: 1.6;
        }

        .notif-time {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 3px;
        }

        /* =========================================================
                   APPOINTMENT CARD (Student)
                ========================================================= */

        .appt-card {
            background: linear-gradient(135deg, #f9fdfb, #eef7f2);
            border: 1.5px solid #c3e6d0;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 16px;
        }

        .appt-card:last-child {
            margin-bottom: 0;
        }

        .appt-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .appt-card-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--dusk);
        }

        .appt-card-body {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .appt-card-footer {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #d8eedf;
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .appt-meta {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .appt-meta i {
            font-size: 14px;
        }

        /* Interview Highlight Box */
        .interview-box {
            background: linear-gradient(135deg, #faf5ff, #f3e8ff);
            border: 1.5px solid #c4b5fd;
            border-radius: 14px;
            padding: 18px 20px;
        }

        .interview-box-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .interview-box-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #ede9fe;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .interview-box-icon i {
            color: #7c3aed;
            font-size: 20px;
        }

        .interview-box-title {
            font-size: 13px;
            font-weight: 700;
            color: #5b21b6;
        }

        .interview-box-sub {
            font-size: 11.5px;
            color: #7c3aed;
        }

        .interview-detail {
            display: flex;
            gap: 8px;
            align-items: center;
            font-size: 12.5px;
            color: #4c1d95;
            margin-bottom: 6px;
        }

        .interview-detail i {
            font-size: 15px;
            color: #7c3aed;
        }

        /* Feed Posts */
        .feed-post {
            border-bottom: 1px solid #f3ede5;
            padding-bottom: 16px;
        }

        .feed-post:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .feed-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--dusk);
            margin-bottom: 6px;
        }

        .feed-body {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .feed-time {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 8px;
        }

        /* Privacy Card */
        .privacy-card {
            background: linear-gradient(135deg, #ffffff, #f9fdfb);
            border: 1px solid #d9f2df;
        }

        .privacy-content {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .privacy-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #effcf3;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .privacy-icon i {
            color: #16a34a;
            font-size: 20px;
        }

        .privacy-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--dusk);
            margin-bottom: 4px;
        }

        .privacy-text {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* Section divider label */
        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f0e8de;
        }

        /* =========================================================
                   RESPONSIVE
                ========================================================= */

        @media (max-width: 1200px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .stat-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-title {
                font-size: 24px;
            }
        }
    </style>
@endsection

@section('content')

    {{-- =========================================================
    GREETING
    ========================================================= --}}
    <div class="dashboard-header">
        <h1 class="dashboard-title">
            Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }},
            {{ explode(' ', auth()->user()->name)[0] }} ✨
        </h1>
        <p class="dashboard-subtitle">
            {{ now()->format('l, F j, Y') }}
            ·
            @if (auth()->user()->isAdmin())
                Admin Portal — Full access
            @else
                Student Portal — {{ auth()->user()->program_section ?? 'PLSP' }}
            @endif
        </p>
    </div>

    @if (auth()->user()->isAdmin())

        {{-- =========================================================
        ADMIN VIEW
        ========================================================= --}}

        {{-- Admin Notifications Banner --}}
        @if (isset($adminNotifications) && $adminNotifications->isNotEmpty())
            <div class="card" style="margin-bottom:18px;border-left:4px solid var(--sage);">
                <div class="card-header">
                    <span class="card-title" style="display:flex;align-items:center;gap:8px;">
                        <i class="ti ti-bell-ringing" style="color:var(--sage);font-size:18px;"></i>
                        Unread Notifications
                    </span>
                    <span class="badge badge-pending">{{ $adminNotifications->count() }} new</span>
                </div>
                <div class="card-body" style="padding-top:0;">
                    @foreach ($adminNotifications as $notif)
                        <div class="notif-item">
                            <div class="notif-dot"></div>
                            <div>
                                <div class="notif-text">{{ $notif->message }}</div>
                                <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- STAT CARDS — Row 1: Core stats --}}
        <div class="stat-grid">

            <div class="stat-card sage">
                <div class="stat-card-header">
                    <span class="stat-card-label">Students this semester</span>
                    <div class="stat-card-icon" style="background:var(--sky-pale);color:var(--sky);">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['total_students'] ?? 0 }}</div>
                <div class="stat-card-sub">Registered in eKalinga</div>
            </div>

            <div class="stat-card gold">
                <div class="stat-card-header">
                    <span class="stat-card-label">Active cases</span>
                    <div class="stat-card-icon" style="background:var(--gold-pale);color:#b7791f;">
                        <i class="ti ti-file-alert"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['active_cases'] ?? 0 }}</div>
                <div class="stat-card-sub">Processing / Confirmed / Scheduled</div>
            </div>

            <div class="stat-card blush">
                <div class="stat-card-header">
                    <span class="stat-card-label">Pending appointments</span>
                    <div class="stat-card-icon" style="background:var(--blush-pale);color:#9a6065;">
                        <i class="ti ti-clock"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['pending_appointments'] ?? 0 }}</div>
                <div class="stat-card-sub">Awaiting your review</div>
            </div>

            <div class="stat-card sky">
                <div class="stat-card-header">
                    <span class="stat-card-label">Unread messages</span>
                    <div class="stat-card-icon" style="background:var(--sage-pale);color:var(--sage);">
                        <i class="ti ti-message-circle"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['unread_messages'] ?? 0 }}</div>
                <div class="stat-card-sub">From students</div>
            </div>

        </div>

        {{-- STAT CARDS — Row 2: Appointment deep stats --}}
        <div class="stat-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:28px;">

            <div class="stat-card rose">
                <div class="stat-card-header">
                    <span class="stat-card-label">Urgent appointments</span>
                    <div class="stat-card-icon" style="background:#fef2f2;color:#dc2626;">
                        <i class="ti ti-urgent"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['urgent_appointments'] ?? 0 }}</div>
                <div class="stat-card-sub">Need immediate attention</div>
            </div>

            <div class="stat-card sage">
                <div class="stat-card-header">
                    <span class="stat-card-label">Interviews today</span>
                    <div class="stat-card-icon" style="background:var(--sage-pale);color:var(--sage);">
                        <i class="ti ti-calendar-event"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['scheduled_today'] ?? 0 }}</div>
                <div class="stat-card-sub">Scheduled for today</div>
            </div>

            <div class="stat-card sky">
                <div class="stat-card-header">
                    <span class="stat-card-label">Total appointments</span>
                    <div class="stat-card-icon" style="background:var(--sky-pale);color:var(--sky);">
                        <i class="ti ti-files"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['total_appointments'] ?? 0 }}</div>
                <div class="stat-card-sub">All time</div>
            </div>

        </div>

        {{-- MAIN CONTENT GRID --}}
        <div class="content-grid">

            {{-- LEFT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:18px;">

                {{-- Pending Appointments (Urgent First) --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
                            <i class="ti ti-clock" style="color:var(--gold);"></i>
                            Pending Appointments
                        </span>
                        <a href="{{ route('admin.appointments.index') }}" class="btn-sm">
                            <i class="ti ti-arrow-right"></i> View all
                        </a>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Concern</th>
                                    <th>Urgency</th>
                                    <th>Submitted</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingAppointments ?? [] as $appt)
                                    <tr>
                                        <td>
                                            <div class="student-row">
                                                <div class="student-avatar">
                                                    {{ strtoupper(substr($appt->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="student-name">{{ $appt->user->name ?? '—' }}</div>
                                                    <div style="font-size:11px;color:var(--text-muted);">
                                                        {{ $appt->user->program_section ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="max-width:160px;">
                                            <span style="font-size:12.5px;color:var(--text);">
                                                {{ Str::limit($appt->concern ?? $appt->reason_for_consultation ?? '—', 50) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php $u = strtolower($appt->urgency_level ?? 'low'); @endphp
                                            <span class="badge badge-{{ $u }}">
                                                <i
                                                    class="ti ti-{{ $u === 'urgent' ? 'alert-triangle' : ($u === 'moderate' ? 'minus' : 'circle-check') }}"></i>
                                                {{ ucfirst($u) }}
                                            </span>
                                        </td>
                                        <td style="font-size:12px;color:var(--text-muted);">
                                            {{ $appt->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.appointments.show', $appt) }}" class="btn-sm"
                                                style="padding:7px 12px;">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <i class="ti ti-clipboard-check"></i>
                                                <p>No pending appointments. You're all caught up!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Upcoming Interviews --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
                            <i class="ti ti-calendar-event" style="color:#7c3aed;"></i>
                            Upcoming Interviews
                        </span>
                        <a href="{{ route('admin.appointments.index') }}?status=interview_scheduled" class="btn-sm">
                            <i class="ti ti-arrow-right"></i> View all
                        </a>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($upcomingInterviews ?? [] as $appt)
                                    <tr>
                                        <td>
                                            <div class="student-row">
                                                <div class="student-avatar">
                                                    {{ strtoupper(substr($appt->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="student-name">{{ $appt->user->name ?? '—' }}</div>
                                                    <div style="font-size:11px;color:var(--text-muted);">
                                                        {{ $appt->user->program_section ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-size:13px;font-weight:600;color:var(--dusk);">
                                            @if ($appt->schedule)
                                                {{ \Carbon\Carbon::parse($appt->schedule->interview_date)->format('M d, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td style="font-size:13px;color:var(--text-muted);">
                                            @if ($appt->schedule && $appt->schedule->interview_time)
                                                {{ \Carbon\Carbon::parse($appt->schedule->interview_time)->format('h:i A') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-interview">
                                                <i class="ti ti-calendar"></i> Scheduled
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.appointments.show', $appt) }}" class="btn-sm"
                                                style="padding:7px 12px;">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <i class="ti ti-calendar-off"></i>
                                                <p>No upcoming interviews scheduled.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Recent Students --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Recent Student Records</span>
                        <a href="{{ route('admin.students.index') }}" class="btn-sm">
                            <i class="ti ti-arrow-right"></i> View all
                        </a>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Program</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentStudents ?? [] as $student)
                                    <tr>
                                        <td>
                                            <div class="student-row">
                                                <div class="student-avatar">
                                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                                </div>
                                                <div class="student-name">{{ $student->name }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $student->program_section ?? '—' }}</td>
                                        <td>{{ $student->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <div class="empty-state">
                                                <i class="ti ti-users"></i>
                                                <p>No students registered yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:18px;">

                {{-- Quick Actions --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Quick Actions</span>
                    </div>
                    <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                        <a href="{{ route('admin.appointments.index') }}" class="btn-sm btn-primary"
                            style="justify-content:center;">
                            <i class="ti ti-calendar-check"></i> Manage Appointments
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-users"></i> Student Records
                        </a>
                        <a href="{{ route('feed.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-news"></i> Org Feed
                        </a>
                        <a href="{{ route('messages.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-message-circle"></i> Messages
                            @if (($stats['unread_messages'] ?? 0) > 0)
                                <span class="badge badge-urgent" style="margin-left:auto;">{{ $stats['unread_messages'] }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-chart-bar"></i> Reports
                        </a>
                    </div>
                </div>

                {{-- Today's Schedule Summary --}}
                <div class="card" style="border-left:4px solid #7c3aed;">
                    <div class="card-header">
                        <span class="card-title" style="display:flex;align-items:center;gap:8px;">
                            <i class="ti ti-calendar-today" style="color:#7c3aed;"></i>
                            Today's Schedule
                        </span>
                    </div>
                    <div class="card-body">
                        @if (($stats['scheduled_today'] ?? 0) > 0)
                            <div style="text-align:center;padding:10px 0;">
                                <div style="font-family:'Playfair Display',serif;font-size:38px;font-weight:700;color:#7c3aed;">
                                    {{ $stats['scheduled_today'] }}
                                </div>
                                <div style="font-size:12.5px;color:var(--text-muted);margin-top:4px;">
                                    interview{{ $stats['scheduled_today'] > 1 ? 's' : '' }} scheduled today
                                </div>
                                <a href="{{ route('admin.appointments.index') }}?date=today" class="btn-sm"
                                    style="margin-top:14px;justify-content:center;width:100%;background:var(--sage-pale);color:var(--sage);">
                                    <i class="ti ti-list"></i> View today's interviews
                                </a>
                            </div>
                        @else
                            <div class="empty-state" style="padding:20px 10px;">
                                <i class="ti ti-calendar-off" style="font-size:24px;"></i>
                                <p>No interviews scheduled for today.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Top Concerns --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Top concerns this month</span>
                    </div>
                    <div class="card-body">
                        @foreach ($trends ?? [['label' => 'Academic stress', 'pct' => 45], ['label' => 'Family issues', 'pct' => 28], ['label' => 'Mental health', 'pct' => 19], ['label' => 'Other', 'pct' => 8]] as $trend)
                            <div class="trend-group">
                                <div class="trend-top">
                                    <span class="trend-label">{{ $trend['label'] }}</span>
                                    <span class="trend-percent">{{ $trend['pct'] }}%</span>
                                </div>
                                <div class="trend-bar">
                                    <div class="trend-fill" style="width:{{ $trend['pct'] }}%;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

    @else

        {{-- =========================================================
        STUDENT VIEW
        ========================================================= --}}

        {{-- Student Notifications Banner --}}
        @if (isset($myNotifications) && $myNotifications->isNotEmpty())
            <div class="card" style="margin-bottom:18px;border-left:4px solid var(--sage);">
                <div class="card-header">
                    <span class="card-title" style="display:flex;align-items:center;gap:8px;">
                        <i class="ti ti-bell-ringing" style="color:var(--sage);font-size:18px;"></i>
                        Your Notifications
                    </span>
                    <span class="badge badge-pending">{{ $myNotifications->count() }} new</span>
                </div>
                <div class="card-body" style="padding-top:0;">
                    @foreach ($myNotifications as $notif)
                        <div class="notif-item">
                            <div class="notif-dot"></div>
                            <div>
                                <div class="notif-text">{{ $notif->message }}</div>
                                <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- STAT CARDS --}}
        <div class="stat-grid">

            <div class="stat-card sage">
                <div class="stat-card-header">
                    <span class="stat-card-label">Sessions attended</span>
                    <div class="stat-card-icon" style="background:var(--sage-pale);color:var(--sage);">
                        <i class="ti ti-file-text"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['sessions'] ?? 0 }}</div>
                <div class="stat-card-sub">Completed this semester</div>
            </div>

            <div class="stat-card sky">
                <div class="stat-card-header">
                    <span class="stat-card-label">Messages sent</span>
                    <div class="stat-card-icon" style="background:var(--sky-pale);color:var(--sky);">
                        <i class="ti ti-message-circle"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['messages_sent'] ?? 0 }}</div>
                <div class="stat-card-sub">To your facilitator</div>
            </div>

            <div class="stat-card gold">
                <div class="stat-card-header">
                    <span class="stat-card-label">My appointments</span>
                    <div class="stat-card-icon" style="background:var(--gold-pale);color:#b7791f;">
                        <i class="ti ti-files"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['total_appointments'] ?? 0 }}</div>
                <div class="stat-card-sub">
                    {{ $stats['pending_appointments'] ?? 0 }} pending ·
                    {{ $stats['active_appointments'] ?? 0 }} active
                </div>
            </div>

            <div class="stat-card sky" style="--sky:#7c3aed;">
                <div class="stat-card-header">
                    <span class="stat-card-label">Next interview</span>
                    <div class="stat-card-icon" style="background:#ede9fe;color:#7c3aed;">
                        <i class="ti ti-calendar-event"></i>
                    </div>
                </div>
                @if ($nextAppointment && $nextAppointment->schedule)
                    <div class="stat-card-value" style="font-size:20px;">
                        {{ \Carbon\Carbon::parse($nextAppointment->schedule->interview_date)->format('M d') }}
                    </div>
                    <div class="stat-card-sub">
                        {{ \Carbon\Carbon::parse($nextAppointment->schedule->interview_time)->format('h:i A') ?? '' }}
                    </div>
                @else
                    <div class="stat-card-value" style="font-size:18px;">None</div>
                    <div class="stat-card-sub">No upcoming interviews</div>
                @endif
            </div>

        </div>

        {{-- MAIN CONTENT GRID --}}
        <div class="content-grid">

            {{-- LEFT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:18px;">

                {{-- Next Interview Highlight --}}
                @if ($nextAppointment && $nextAppointment->schedule)
                    <div class="interview-box">
                        <div class="interview-box-header">
                            <div class="interview-box-icon">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                            <div>
                                <div class="interview-box-title">Upcoming Interview Session</div>
                                <div class="interview-box-sub">Your counseling session is confirmed</div>
                            </div>
                        </div>
                        <div class="interview-detail">
                            <i class="ti ti-calendar"></i>
                            {{ \Carbon\Carbon::parse($nextAppointment->schedule->interview_date)->format('l, F j, Y') }}
                        </div>
                        @if ($nextAppointment->schedule->interview_time)
                            <div class="interview-detail">
                                <i class="ti ti-clock"></i>
                                {{ \Carbon\Carbon::parse($nextAppointment->schedule->interview_time)->format('h:i A') }}
                            </div>
                        @endif
                        @if ($nextAppointment->schedule->meeting_details ?? null)
                            <div class="interview-detail">
                                <i class="ti ti-map-pin"></i>
                                {{ $nextAppointment->schedule->meeting_details }}
                            </div>
                        @endif
                        @if ($nextAppointment->schedule->counselor_notes ?? null)
                            <div style="margin-top:12px;padding:12px;background:rgba(124,58,237,.06);border-radius:10px;">
                                <div style="font-size:12px;font-weight:700;color:#5b21b6;margin-bottom:4px;">
                                    <i class="ti ti-notes"></i> Counselor note
                                </div>
                                <div style="font-size:12.5px;color:#4c1d95;line-height:1.6;">
                                    {{ $nextAppointment->schedule->counselor_notes }}
                                </div>
                            </div>
                        @endif
                        <div style="margin-top:14px;">
                            <a href="{{ route('appointments.show', $nextAppointment) }}" class="btn-sm btn-primary"
                                style="justify-content:center;width:100%;">
                                <i class="ti ti-eye"></i> View appointment details
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Current / Latest Active Appointment --}}
                @if ($latestAppointment)
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title" style="display:flex;align-items:center;gap:8px;">
                                <i class="ti ti-file-description" style="color:var(--sage);"></i>
                                Current Appointment
                            </span>
                            @php $s = strtolower(str_replace('_', '-', $latestAppointment->status)); @endphp
                            <span class="badge badge-{{ $s }}">
                                {{ ucwords(str_replace('_', ' ', $latestAppointment->status)) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="section-label">Concern / Reason</div>
                            <p style="font-size:13px;color:var(--text);line-height:1.7;margin-bottom:16px;">
                                {{ $latestAppointment->concern ?? $latestAppointment->reason_for_consultation ?? 'No details provided.' }}
                            </p>
                            <div style="display:flex;gap:16px;flex-wrap:wrap;">
                                <div class="appt-meta">
                                    <i class="ti ti-calendar"></i>
                                    Requested {{ $latestAppointment->created_at->diffForHumans() }}
                                </div>
                                @if ($latestAppointment->urgency_level)
                                    <div class="appt-meta">
                                        <i class="ti ti-alert-triangle"></i>
                                        {{ ucfirst($latestAppointment->urgency_level) }} urgency
                                    </div>
                                @endif
                                @if ($latestAppointment->preferred_date)
                                    <div class="appt-meta">
                                        <i class="ti ti-clock"></i>
                                        Preferred: {{ \Carbon\Carbon::parse($latestAppointment->preferred_date)->format('M d') }}
                                        @if ($latestAppointment->preferred_time)
                                            at {{ \Carbon\Carbon::parse($latestAppointment->preferred_time)->format('h:i A') }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div style="margin-top:14px;">
                                <a href="{{ route('appointments.show', $latestAppointment) }}" class="btn-sm"
                                    style="justify-content:center;">
                                    <i class="ti ti-eye"></i> View full details
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Appointment History --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Appointment History</span>
                        <a href="{{ route('appointments.index') }}" class="btn-sm">
                            <i class="ti ti-arrow-right"></i> View all
                        </a>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Concern</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($appointmentHistory ?? [] as $i => $appt)
                                    <tr>
                                        <td style="font-size:12px;color:var(--text-muted);">
                                            #{{ $appt->id }}
                                        </td>
                                        <td style="max-width:180px;">
                                            <span style="font-size:12.5px;">
                                                {{ Str::limit($appt->concern ?? $appt->reason_for_consultation ?? '—', 45) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php $s = strtolower(str_replace('_', '-', $appt->status)); @endphp
                                            <span class="badge badge-{{ $s }}">
                                                {{ ucwords(str_replace('_', ' ', $appt->status)) }}
                                            </span>
                                        </td>
                                        <td style="font-size:12px;color:var(--text-muted);">
                                            {{ $appt->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <i class="ti ti-clipboard-list"></i>
                                                <p>No appointment history yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Org Feed --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Latest from the Org</span>
                        <a href="{{ route('feed.index') }}" class="btn-sm">
                            <i class="ti ti-arrow-right"></i> See all
                        </a>
                    </div>
                    <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">
                        @forelse ($feedPosts ?? [] as $post)
                            <div class="feed-post">
                                <div class="feed-title">{{ $post->title }}</div>
                                <div class="feed-body">{{ Str::limit($post->body, 100) }}</div>
                                <div class="feed-time">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="ti ti-news"></i>
                                <p>No posts yet. Check back soon!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:18px;">

                {{-- Request Appointment CTA --}}
                <div class="card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1.5px solid #86efac;">
                    <div class="card-body" style="text-align:center;padding:28px 20px;">
                        <div
                            style="width:52px;height:52px;border-radius:16px;background:#bbf7d0;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                            <i class="ti ti-calendar-plus" style="font-size:26px;color:#16a34a;"></i>
                        </div>
                        <div style="font-size:15px;font-weight:700;color:#14532d;margin-bottom:8px;">
                            Need to talk to someone?
                        </div>
                        <div style="font-size:12.5px;color:#166534;line-height:1.7;margin-bottom:18px;">
                            Request a counseling appointment and our facilitators will reach out to you.
                        </div>
                        <a href="{{ route('appointments.create') }}" class="btn-sm btn-primary"
                            style="justify-content:center;width:100%;background:linear-gradient(135deg,#16a34a,#15803d);">
                            <i class="ti ti-plus"></i> Request Appointment
                        </a>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Quick Actions</span>
                    </div>
                    <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                        <a href="{{ route('messages.index') }}" class="btn-sm btn-primary" style="justify-content:center;">
                            <i class="ti ti-message-circle"></i> Message your facilitator
                        </a>
                        <a href="{{ route('appointments.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-calendar-check"></i> My appointments
                        </a>
                        <a href="{{ route('student.sessions') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-file-text"></i> View session history
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-user-circle"></i> Update my profile
                        </a>
                    </div>
                </div>

                {{-- Privacy Card --}}
                <div class="card privacy-card">
                    <div class="card-body">
                        <div class="privacy-content">
                            <div class="privacy-icon">
                                <i class="ti ti-shield-check"></i>
                            </div>
                            <div>
                                <div class="privacy-title">Your privacy is protected</div>
                                <div class="privacy-text">
                                    Your records and conversations are encrypted and only visible to authorized facilitators.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    @endif

@endsection