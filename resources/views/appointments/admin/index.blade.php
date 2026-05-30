@extends('dashboard.layout')@section('title', 'Manage Appointments')@section('head'):
    <style>
        :root {
            --green-dark: #1a6b3c;
            --green-mid: #2d8653;
            --green-light: #e8f5ee;
            --green-pale: #f2faf5;
            --green-border: #b6dfc7;
            --text-dark: #1a2e22;
            --text-mid: #3d6b50;
            --text-soft: #6b9e7e;
            --text-muted: #9dbdac;
            --white: #ffffff;
            --danger: #c0392b;
            --warning: #e67e22;
            --shadow: 0 2px 16px rgba(26, 107, 60, 0.08);
            --radius: 10px;
        }

        .appt-page {
            background: var(--green-pale);
            min-height: calc(100vh - 60px);
            padding: 1.5rem 1rem;
        }

        .appt-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* —— Page header —— */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 10px;
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title .icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: var(--green-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 17px;
        }

        .page-sub {
            font-size: 12px;
            color: var(--text-soft);
            margin-top: 3px;
            margin-left: 46px;
        }

        /* —— Stats —— */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        @media(max-width:900px) {
            .stats-row {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:500px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--green-border);
            border-radius: var(--radius);
            padding: 12px 14px;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .stat-icon {
            font-size: 22px;
            margin-bottom: 4px;
            display: block;
        }

        .stat-val {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            display: block;
            line-height: 1;
        }

        .stat-lbl {
            font-size: 10px;
            color: var(--text-soft);
            margin-top: 3px;
            font-weight: 500;
        }

        /* —— Filters —— */
        .filters-bar {
            background: var(--white);
            border: 1px solid var(--green-border);
            border-radius: var(--radius);
            padding: 12px 16px;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            box-shadow: var(--shadow);
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-mid);
            white-space: nowrap;
        }

        .filter-chips {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .filter-chip {
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid var(--green-border);
            background: var(--green-pale);
            font-size: 12px;
            color: var(--text-mid);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.12s;
            white-space: nowrap;
        }

        .filter-chip:hover {
            border-color: var(--green-mid);
        }

        .filter-chip.active {
            background: var(--green-mid);
            color: #fff;
            border-color: var(--green-mid);
            font-weight: 600;
        }

        .filter-search {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-search input {
            padding: 6px 12px;
            border: 1.5px solid var(--green-border);
            border-radius: 20px;
            font-size: 12px;
            color: var(--text-dark);
            background: var(--white);
            font-family: inherit;
            width: 180px;
        }

        .filter-search input:focus {
            outline: none;
            border-color: var(--green-mid);
        }

        /* —— Table —— */
        .appt-table-wrap {
            background: var(--white);
            border: 1px solid var(--green-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
        }

        thead th {
            padding: 12px 14px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #fff;
            text-align: left;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--green-border);
            transition: background 0.1s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--green-pale);
        }

        tbody td {
            padding: 12px 14px;
            font-size: 13px;
            color: var(--text-dark);
            vertical-align: middle;
        }

        .td-student {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .student-av {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--green-mid);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .student-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .student-id {
            font-size: 11px;
            color: var(--text-soft);
        }

        .status-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background: #cfe2ff;
            color: #0a4a8c;
        }

        .status-confirmed {
            background: var(--green-light);
            color: var(--green-dark);
        }

        .status-scheduled {
            background: #e0d4f7;
            color: #5b2d8e;
        }

        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .urgency-badge {
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .urg-urgent {
            background: #fde8e6;
            color: #c0392b;
        }

        .urg-moderate {
            background: #fef3e0;
            color: #d35400;
        }

        .urg-low {
            background: var(--green-light);
            color: var(--green-dark);
        }

        .td-actions {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .btn-action {
            padding: 5px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            text-decoration: none;
            transition: all 0.12s;
            white-space: nowrap;
        }

        .btn-view {
            background: var(--green-light);
            color: var(--green-dark);
        }

        .btn-view:hover {
            background: var(--green-border);
        }

        .btn-schedule {
            background: #e0d4f7;
            color: #5b2d8e;
        }

        .btn-schedule:hover {
            background: #cbb8f0;
        }

        /* —— Pagination —— */
        .table-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--green-border);
            background: #fafcfb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-soft);
            flex-wrap: wrap;
            gap: 8px;
        }

        /* —— Empty —— */
        .empty-row td {
            text-align: center;
            padding: 3rem;
            color: var(--text-soft);
            font-size: 13px;
        }
    </style>
@endsection

@section('content')
    <div class="appt-page">
        <div class="appt-container">

            {{-- Header --}}
            <div class="page-header">
                <div>
                    <div class="page-title">
                        <div class="icon">📋</div>
                        Appointment Management
                    </div>
                    <div class="page-sub">Review, update, and schedule counseling sessions for all student requests.</div>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div
                    style="background:#d4edda;border:1px solid #c3e6cb;border-radius:var(--radius);padding:10px 14px;margin-bottom:1rem;font-size:13px;color:#155724;display:flex;align-items:center;gap:8px">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Stats Row --}}
            <div class="stats-row">
                <div class="stat-card">
                    <span class="stat-icon">📋</span>
                    <span class="stat-val">{{ $stats['total'] }}</span>
                    <span class="stat-lbl">Total</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">⏳</span>
                    <span class="stat-val">{{ $stats['pending'] }}</span>
                    <span class="stat-lbl">Pending</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">🔄</span>
                    <span class="stat-val">{{ $stats['processing'] }}</span>
                    <span class="stat-lbl">Processing</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">📅</span>
                    <span class="stat-val">{{ $stats['scheduled'] }}</span>
                    <span class="stat-lbl">Scheduled</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">✅</span>
                    <span class="stat-val">{{ $stats['completed'] }}</span>
                    <span class="stat-lbl">Completed</span>
                </div>
                <div class="stat-card">
                    <span class="stat-icon">🔴</span>
                    <span class="stat-val">{{ $stats['urgent'] }}</span>
                    <span class="stat-lbl">Urgent</span>
                </div>
            </div>

            {{-- Filters Bar --}}
            <div class="filters-bar">
                <span class="filter-label">Filter:</span>
                <div class="filter-chips">
                    @foreach([
                            'all' => 'All',
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'confirmed' => 'Confirmed',
                            'interview_scheduled' => 'Scheduled',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ] as $val => $label)
                                <a href="{{ route('admin.appointments.index', ['status' => $val]) }}"
                                   class="filter-chip {{ (request('status', 'all') === $val) ? 'active' : '' }}">
                                    {{ $label }}
                                    @if($val !== 'all' && isset($stats[$val]))
                                        ({{ $stats[$val] }})

                                       @endif
                                </a>
                    @endforeach
                </div>
                <div class="filter-search">
                    <form method="GET" action="{{ route('admin.appointments.index') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}" />
                        <input type="text" name="search" placeholder="🔍 Search name, ID..." value="{{ request('search') }}" />
                    </form>
                </div>
            </div>

            {{-- Appointments Table Wrap --}}
            <div class="appt-table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Course / Year</th>
                            <th>Preferred Schedule</th>
                        <th>Urgency</th>
                    <th>Status</th>
                <th>Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appt)
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
                    $uc = ['urgent' => 'urg-urgent', 'moderate' => 'urg-moderate', 'low' => 'urg-low'];
                @endphp
                    <tr>
                        <td style="font-size:12px;color:var(--text-muted);font-weight:600">#{{ $appt->id }}</td>
                        <td>
                            <div class="td-student">
                                <div class="student-av">{{ strtoupper(substr($appt->full_name, 0, 2)) }}</div>
                                <div>
                                    <div class="student-name">{{ $appt->full_name }}</div>
                                    <div class="student-id">{{ $appt->student_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size:13px;font-weight:500">{{ $appt->course }}</span><br>
                            <span style="font-size:11px;color:var(--text-soft)">{{ $appt->year_level }}</span>
                        </td>
                        <td>

                                                           <span style="font-size:13px;font-weight:500">
                                {{ \Carbon\Carbon::parse($appt->preferred_date)->format('M d, Y') }}
                            </span><br>
                            <span style="font-size:11px;color:var(--text-soft)">{{ $appt->preferred_time }}</span>
                        </td>
                        <td>
                            <span class="urgency-badge {{ $uc[$appt->urgency_level] ?? 'urg-low' }}">
                                @if($appt->urgency_level === 'urgent') 🔴 @elseif($appt->urgency_level === 'moderate') 🟡 @else 🟢 @endif
                                {{ ucfirst($appt->urgency_level) }}
                            </span>
                        </td>
                    <td><span class="status-badge {{ $s['class'] }}">{{ $s['label'] }}</span></td>
                    <td style="font-size:11px;color:var(--text-soft)">{{ $appt->created_at->diffForHumans() }}</td>
                    <td>
                            <div class="td-actions">
                                <a href="{{ route('admin.appointments.show', $appt) }}" class="btn-action btn-view">
                                    👁️ View
                                </a>
                                    @if(!in_array($appt->status, ['completed', 'cancelled']))
                                        <a href="{{ route('admin.appointments.show', $appt) }}" class="btn-action btn-schedule">
                                            📅 Schedule
                                        </a>
                                    @endif
                            </div>
                        </td>
                        </tr>
            @empty
                            <tr class="empty-row">
                                <td colspan="8">
                                    <div style="font-size:36px;margin-bottom:8px">📬</div>
                                    No appointments found.

                                                   </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="table-footer">
                    <span>Showing {{ $appointments->firstItem() }}–{{ $appointments->lastItem() }} of {{ $appointments->total() }} appointments</span>
                    {{ $appointments->appends(request()->query())->links() }}
                </div>
            </div>

        </div>
        </div>
@endsection