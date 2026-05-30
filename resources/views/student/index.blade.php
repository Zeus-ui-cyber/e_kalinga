@extends('dashboard.layout')
@section('title', 'My Appointments')

@section('head')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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
            --white: #ffffff;
            --danger: #c0392b;
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 4px rgba(10, 61, 31, 0.07);
            --shadow: 0 4px 20px rgba(10, 61, 31, 0.09);
            --transition: 0.18s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .appt-page {
            background: var(--g8);
            min-height: calc(100vh - 120px);
            padding: 1rem 0 2rem;
        }

        .appt-container {
            max-width: 920px;
            margin: 0 auto;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            animation: fadeDown 0.4s ease both;
        }

        .page-title {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--text-head);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 400;
        }

        .title-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--g1), var(--g3));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(10, 61, 31, 0.25);
        }

        .page-sub {
            font-size: 13px;
            color: var(--text-soft);
            margin-top: 5px;
            padding-left: 50px;
        }

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--g1), var(--g3));
            color: #fff;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(10, 61, 31, 0.28);
            transition: transform var(--transition), box-shadow var(--transition);
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-new:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(10, 61, 31, 0.34);
        }

        .flash-success {
            background: var(--g7);
            border: 1px solid var(--gborder);
            border-left: 4px solid var(--g4);
            border-radius: var(--radius-sm);
            padding: 11px 16px;
            margin-bottom: 1.25rem;
            font-size: 13px;
            color: var(--g1);
            display: flex;
            align-items: center;
            gap: 8px;
            animation: fadeDown 0.35s ease both;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.45s 0.05s ease both;
        }

        @media(max-width: 580px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--gborder);
            border-radius: var(--radius);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-sm);
            transition: box-shadow var(--transition), transform var(--transition);
        }

        .stat-card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-1px);
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .stat-val {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-head);
            line-height: 1;
        }

        .stat-lbl {
            font-size: 11px;
            color: var(--text-soft);
            margin-top: 3px;
            font-weight: 500;
        }

        .appt-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .appt-item {
            background: var(--white);
            border: 1px solid var(--gborder);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: box-shadow var(--transition), transform var(--transition);
            animation: fadeUp 0.4s ease both;
        }

        .appt-item:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .appt-item-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 18px;
            border-bottom: 1px solid var(--g7);
            background: var(--g8);
        }

        .appt-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--g1), var(--g3));
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .appt-title-wrap {
            flex: 1;
            min-width: 0;
        }

        .appt-title-wrap h3 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-head);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .appt-title-wrap .submitted {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
            display: block;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            letter-spacing: 0.01em;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-pending::before {
            background: #f0ad4e;
        }

        .status-processing {
            background: #cfe2ff;
            color: #0a4a8c;
        }

        .status-processing::before {
            background: #3d8bcd;
        }

        .status-confirmed {
            background: var(--g7);
            color: var(--g1);
        }

        .status-confirmed::before {
            background: var(--g4);
        }

        .status-scheduled {
            background: #ede7f6;
            color: #4527a0;
        }

        .status-scheduled::before {
            background: #7c4dff;
        }

        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-completed::before {
            background: #17a2b8;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .status-cancelled::before {
            background: var(--danger);
        }

        .appt-item-body {
            padding: 16px 18px;
        }

        .appt-meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 14px;
        }

        @media(max-width: 560px) {
            .appt-meta-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .meta-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 3px;
        }

        .meta-label i {
            font-size: 12px;
        }

        .meta-val {
            font-size: 13px;
            color: var(--text-head);
            font-weight: 500;
        }

        .urg-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 4px;
            vertical-align: middle;
        }

        .urg-low {
            background: var(--g4);
        }

        .urg-moderate {
            background: #f39c12;
        }

        .urg-urgent {
            background: var(--danger);
        }

        .appt-concern {
            background: var(--g8);
            border: 1px solid var(--g7);
            border-left: 3px solid var(--g4);
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            padding: 11px 14px;
            font-size: 13px;
            color: var(--text-body);
            line-height: 1.6;
        }

        .appt-concern .concern-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }

        .interview-notice {
            background: #ede7f6;
            border: 1px solid #ce93d8;
            border-left: 3px solid #7c4dff;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            padding: 10px 14px;
            margin-top: 10px;
            font-size: 12px;
            color: #4527a0;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.55;
        }

        .interview-notice i {
            font-size: 15px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .appt-item-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 18px;
            border-top: 1px solid var(--g7);
            background: var(--g8);
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-info {
            font-size: 11px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .footer-actions {
            display: flex;
            gap: 6px;
        }

        .btn-sm {
            padding: 5px 13px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            transition: all var(--transition);
            border: 1px solid var(--gborder);
            background: var(--white);
            color: var(--text-body);
        }

        .btn-sm:hover {
            background: var(--g7);
            border-color: var(--g5);
            color: var(--g1);
        }

        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .empty-state {
            background: var(--white);
            border: 1.5px dashed var(--gborder);
            border-radius: var(--radius-lg);
            padding: 3.5rem 1.5rem;
            text-align: center;
            animation: fadeUp 0.4s 0.1s ease both;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: var(--g7);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 28px;
        }

        .empty-state h3 {
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
            font-weight: 400;
            color: var(--text-head);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-soft);
            margin-bottom: 1.25rem;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
    </style>
@endsection

@section('content')
    <div class="appt-page">
        <div class="appt-container">

            {{-- Page header --}}
            <div class="page-header">
                <div>
                    <div class="page-title">
                        <div class="title-icon"><i class="ti ti-brain"></i></div>
                        My Appointments
                    </div>
                    <div class="page-sub">Track your counseling requests and scheduled sessions.</div>
                </div>
                <a href="{{ route('appointments.create') }}" class="btn-new">
                    <i class="ti ti-plus"></i> New Request
                </a>
            </div>

            {{-- Flash message --}}
            @if(session('success'))
                <div class="flash-success">
                    <i class="ti ti-circle-check" style="font-size:16px"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stats row --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fff3cd">
                        <i class="ti ti-clipboard-list" style="font-size:20px;color:#856404"></i>
                    </div>
                    <div>
                        <div class="stat-val">{{ $appointments->total() }}</div>
                        <div class="stat-lbl">Total Requests</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fff3cd">
                        <i class="ti ti-clock" style="font-size:20px;color:#856404"></i>
                    </div>
                    <div>
                        <div class="stat-val">{{ $appointments->where('status', 'pending')->count() }}</div>
                        <div class="stat-lbl">Pending</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#ede7f6">
                        <i class="ti ti-calendar-event" style="font-size:20px;color:#4527a0"></i>
                    </div>
                    <div>
                        <div class="stat-val">{{ $appointments->where('status', 'interview_scheduled')->count() }}</div>
                        <div class="stat-lbl">Scheduled</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#d1ecf1">
                        <i class="ti ti-circle-check" style="font-size:20px;color:#0c5460"></i>
                    </div>
                    <div>
                        <div class="stat-val">{{ $appointments->where('status', 'completed')->count() }}</div>
                        <div class="stat-lbl">Completed</div>
                    </div>
                </div>
            </div>

            {{-- Appointments list --}}
            @if($appointments->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="ti ti-calendar-off" style="font-size:28px;color:var(--text-soft)"></i>
                    </div>
                    <h3>No appointments yet</h3>
                    <p>You haven't submitted any counseling requests. Click the button below to get started.</p>
                    <a href="{{ route('appointments.create') }}" class="btn-new" style="display:inline-flex;margin:0 auto">
                        <i class="ti ti-plus"></i> Request Appointment
                    </a>
                </div>
            @else
                <div class="appt-list">
                    @foreach($appointments as $appt)
                        @php
                            $statusMap = [
                                'pending' => ['label' => 'Pending', 'class' => 'status-pending'],
                                'processing' => ['label' => 'Processing', 'class' => 'status-processing'],
                                'confirmed' => ['label' => 'Confirmed', 'class' => 'status-confirmed'],
                                'interview_scheduled' => ['label' => 'Interview Scheduled', 'class' => 'status-scheduled'],
                                'completed' => ['label' => 'Completed', 'class' => 'status-completed'],
                                'cancelled' => ['label' => 'Cancelled', 'class' => 'status-cancelled'],
                            ];
                            $s = $statusMap[$appt->status] ?? ['label' => ucfirst($appt->status), 'class' => 'status-pending'];
                        @endphp

                        <div class="appt-item">
                            <div class="appt-item-header">
                                <div class="appt-num">{{ $loop->iteration }}</div>
                                <div class="appt-title-wrap">
                                    <h3>Counseling Request #{{ $appt->id }}</h3>
                                    <span class="submitted">
                                        <i class="ti ti-clock" style="font-size:11px;vertical-align:middle"></i>
                                        Submitted {{ $appt->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <span class="status-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                            </div>

                            <div class="appt-item-body">
                                <div class="appt-meta-grid">
                                    <div class="meta-item">
                                        <div class="meta-label"><i class="ti ti-calendar"></i> Preferred Date</div>
                                        <div class="meta-val">{{ \Carbon\Carbon::parse($appt->preferred_date)->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label"><i class="ti ti-clock"></i> Preferred Time</div>
                                        <div class="meta-val">{{ $appt->preferred_time }}</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label"><i class="ti ti-bolt"></i> Urgency</div>
                                        <div class="meta-val">
                                            <span class="urg-dot {{ 'urg-' . $appt->urgency_level }}"></span>
                                            {{ ucfirst($appt->urgency_level) }}
                                        </div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label"><i class="ti ti-school"></i> Course &amp; Year</div>
                                        <div class="meta-val">{{ $appt->course }} — {{ $appt->year_level }}</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label"><i class="ti ti-phone"></i> Contact</div>
                                        <div class="meta-val">{{ $appt->contact_number }}</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-label"><i class="ti ti-mail"></i> Email</div>
                                        <div class="meta-val" style="word-break:break-all">{{ $appt->email }}</div>
                                    </div>
                                </div>

                                <div class="appt-concern">
                                    <span class="concern-label">Your Concern</span>
                                    {{ Str::limit($appt->concern, 200) }}
                                </div>

                                @if($appt->schedule)
                                    <div class="interview-notice">
                                        <i class="ti ti-video"></i>
                                        <div>
                                            <strong>Interview Scheduled:</strong>
                                            {{ \Carbon\Carbon::parse($appt->schedule->interview_date)->format('F d, Y') }}
                                            at {{ $appt->schedule->interview_time }}
                                            @if($appt->schedule->meeting_details)
                                                — {{ $appt->schedule->meeting_details }}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="appt-item-footer">
                                <span class="footer-info">
                                    <i class="ti ti-lock" style="font-size:12px"></i>
                                    Confidential · Only visible to authorized counselors
                                </span>
                                <div class="footer-actions">
                                    <a href="{{ route('appointments.show', $appt) }}" class="btn-sm">
                                        <i class="ti ti-eye"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($appointments->hasPages())
                    <div class="pagination-wrap">
                        {{ $appointments->links() }}
                    </div>
                @endif
            @endif

        </div>
    </div>
@endsection