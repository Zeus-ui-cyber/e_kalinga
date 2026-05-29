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
            FEED POSTS
        ========================================================= */

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

        /* =========================================================
            PRIVACY CARD
        ========================================================= */

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

    {{-- Greeting --}}
    <div class="dashboard-header">

        <h1 class="dashboard-title">
            Good
            {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }},
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
        ========================================================== --}}

        <div class="stat-grid">

            <div class="stat-card sage">

                <div class="stat-card-header">

                    <span class="stat-card-label">
                        Students this semester
                    </span>

                    <div class="stat-card-icon" style="background:var(--sky-pale);color:var(--sky);">
                        <i class="ti ti-users"></i>
                    </div>

                </div>

                <div class="stat-card-value">
                    {{ $stats['total_students'] ?? 0 }}
                </div>

                <div class="stat-card-sub">
                    Registered in eKalinga
                </div>

            </div>

            <div class="stat-card gold">

                <div class="stat-card-header">

                    <span class="stat-card-label">
                        Active cases
                    </span>

                    <div class="stat-card-icon" style="background:var(--gold-pale);color:#b7791f;">
                        <i class="ti ti-file-alert"></i>
                    </div>

                </div>

                <div class="stat-card-value">
                    {{ $stats['active_cases'] ?? 0 }}
                </div>

                <div class="stat-card-sub">
                    Ongoing this week
                </div>

            </div>

            <div class="stat-card blush">

                <div class="stat-card-header">

                    <span class="stat-card-label">
                        Referrals sent
                    </span>

                    <div class="stat-card-icon" style="background:var(--blush-pale);color:#9a6065;">
                        <i class="ti ti-transfer"></i>
                    </div>

                </div>

                <div class="stat-card-value">
                    {{ $stats['referrals'] ?? 0 }}
                </div>

                <div class="stat-card-sub">
                    To Guidance Office
                </div>

            </div>

            <div class="stat-card sky">

                <div class="stat-card-header">

                    <span class="stat-card-label">
                        Unread messages
                    </span>

                    <div class="stat-card-icon" style="background:var(--sage-pale);color:var(--sage);">
                        <i class="ti ti-message-circle"></i>
                    </div>

                </div>

                <div class="stat-card-value">
                    {{ $stats['unread_messages'] ?? 0 }}
                </div>

                <div class="stat-card-sub">
                    From students
                </div>

            </div>

        </div>

        <div class="content-grid">

            {{-- Recent Students --}}
            <div class="card">

                <div class="card-header">

                    <span class="card-title">
                        Recent Student Records
                    </span>

                    <a href="{{ route('admin.students.index') }}" class="btn-sm">
                        <i class="ti ti-arrow-right"></i>
                        View all
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

                                            <div class="student-name">
                                                {{ $student->name }}
                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        {{ $student->program_section ?? '—' }}
                                    </td>

                                    <td>
                                        {{ $student->created_at->diffForHumans() }}
                                    </td>

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

            {{-- Right Column --}}
            <div style="display:flex;flex-direction:column;gap:18px;">

                {{-- Quick Actions --}}
                <div class="card">

                    <div class="card-header">
                        <span class="card-title">Quick Actions</span>
                    </div>

                    <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">

                        <a href="{{ route('admin.students.index') }}" class="btn-sm btn-primary"
                            style="justify-content:center;">
                            <i class="ti ti-users"></i>
                            Student Records
                        </a>

                        <a href="{{ route('feed.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-news"></i>
                            Org Feed
                        </a>

                        <a href="{{ route('messages.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-message-circle"></i>
                            Messages
                        </a>

                        <a href="{{ route('admin.reports.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-chart-bar"></i>
                            Reports
                        </a>

                    </div>

                </div>

                {{-- Trends --}}
                <div class="card">

                    <div class="card-header">
                        <span class="card-title">
                            Top concerns this month
                        </span>
                    </div>

                    <div class="card-body">

                        @foreach ($trends ?? [['label' => 'Academic stress', 'pct' => 45], ['label' => 'Family issues', 'pct' => 28], ['label' => 'Mental health', 'pct' => 19], ['label' => 'Other', 'pct' => 8]] as $trend)

                            <div class="trend-group">

                                <div class="trend-top">

                                    <span class="trend-label">
                                        {{ $trend['label'] }}
                                    </span>

                                    <span class="trend-percent">
                                        {{ $trend['pct'] }}%
                                    </span>

                                </div>

                                <div class="trend-bar">
                                    <div class="trend-fill" style="width:{{ $trend['pct'] }}%;">
                                    </div>
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
        ========================================================== --}}

        <div class="stat-grid">

            <div class="stat-card sage">

                <div class="stat-card-header">

                    <span class="stat-card-label">
                        Sessions attended
                    </span>

                    <div class="stat-card-icon" style="background:var(--sage-pale);color:var(--sage);">
                        <i class="ti ti-file-text"></i>
                    </div>

                </div>

                <div class="stat-card-value">
                    {{ $stats['sessions'] ?? 0 }}
                </div>

                <div class="stat-card-sub">
                    Total this semester
                </div>

            </div>

            <div class="stat-card sky">

                <div class="stat-card-header">

                    <span class="stat-card-label">
                        Messages sent
                    </span>

                    <div class="stat-card-icon" style="background:var(--sky-pale);color:var(--sky);">
                        <i class="ti ti-message-circle"></i>
                    </div>

                </div>

                <div class="stat-card-value">
                    {{ $stats['messages_sent'] ?? 0 }}
                </div>

                <div class="stat-card-sub">
                    To your facilitator
                </div>

            </div>

            <div class="stat-card gold">

                <div class="stat-card-header">

                    <span class="stat-card-label">
                        Next appointment
                    </span>

                    <div class="stat-card-icon" style="background:var(--gold-pale);color:#b7791f;">
                        <i class="ti ti-calendar"></i>
                    </div>

                </div>

                <div class="stat-card-value" style="font-size:18px;">
                    None
                </div>

                <div class="stat-card-sub">
                    No upcoming appointments
                </div>

            </div>

        </div>

        <div class="content-grid">

            {{-- Org Feed --}}
            <div class="card">

                <div class="card-header">

                    <span class="card-title">
                        Latest from the Org
                    </span>

                    <a href="{{ route('feed.index') }}" class="btn-sm">
                        <i class="ti ti-arrow-right"></i>
                        See all
                    </a>

                </div>

                <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">

                    @forelse ($feedPosts ?? [] as $post)

                        <div class="feed-post">

                            <div class="feed-title">
                                {{ $post->title }}
                            </div>

                            <div class="feed-body">
                                {{ Str::limit($post->body, 100) }}
                            </div>

                            <div class="feed-time">
                                {{ $post->created_at->diffForHumans() }}
                            </div>

                        </div>

                    @empty

                        <div class="empty-state">
                            <i class="ti ti-news"></i>
                            <p>No posts yet. Check back soon!</p>
                        </div>

                    @endforelse

                </div>

            </div>

            {{-- Right Column --}}
            <div style="display:flex;flex-direction:column;gap:18px;">

                {{-- Quick Actions --}}
                <div class="card">

                    <div class="card-header">
                        <span class="card-title">Quick Actions</span>
                    </div>

                    <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">

                        <a href="{{ route('messages.index') }}" class="btn-sm btn-primary" style="justify-content:center;">
                            <i class="ti ti-message-circle"></i>
                            Message your facilitator
                        </a>

                        <a href="{{ route('student.sessions') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-file-text"></i>
                            View session history
                        </a>

                        <a href="{{ route('student.profile') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-user-circle"></i>
                            Update my profile
                        </a>

                    </div>

                </div>

                {{-- Privacy --}}
                <div class="card privacy-card">

                    <div class="card-body">

                        <div class="privacy-content">

                            <div class="privacy-icon">
                                <i class="ti ti-shield-check"></i>
                            </div>

                            <div>

                                <div class="privacy-title">
                                    Your privacy is protected
                                </div>

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