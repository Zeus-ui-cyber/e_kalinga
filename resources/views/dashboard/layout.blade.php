<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKalinga — @yield('title', 'Dashboard')</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        :root {
            --sage: #5c7a6e;
            --sage-light: #8aab9c;
            --sage-pale: #d6e8e1;

            --cream: #f5f0e8;
            --warm: #e8dfd0;

            --dusk: #2e3d35;

            --gold: #c9a84c;
            --gold-pale: #f0e8d0;

            --blush: #d4a5a0;
            --blush-pale: #f5e8e6;

            --sky: #7aa3b8;
            --sky-pale: #ddeef5;

            --text: #2e3d35;
            --text-muted: #7a8e85;

            --radius: 18px;
            --radius-sm: 10px;

            --shadow: 0 4px 24px rgba(46, 61, 53, 0.08);
            --shadow-md: 0 8px 40px rgba(46, 61, 53, 0.12);

            --sidebar-w: 260px;
            --topbar-h: 76px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        body {
            display: flex;
        }

        a {
            text-decoration: none;
        }

        button,
        input,
        textarea {
            font-family: inherit;
        }

        /* =========================================================
            SIDEBAR
        ========================================================= */

        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--dusk);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            padding: 0 0 24px;
            transition: transform .3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 28px 24px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .brand-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 12px 16px;
            width: 100%;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--sage-light), var(--gold));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            flex-shrink: 0;
            box-shadow: 0 8px 18px rgba(92, 122, 110, .25);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: .02em;
            line-height: 1.2;
        }

        .brand-sub {
            color: rgba(255, 255, 255, 0.45);
            font-size: 10px;
            font-weight: 400;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* =========================================================
            USER CARD
        ========================================================= */

        .sidebar-user {
            padding: 18px 18px 6px;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            transition: .2s;
        }

        .user-card:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--blush), var(--sage-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
            line-height: 1.3;
        }

        .user-name {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.45);
            font-size: 11px;
            text-transform: capitalize;
        }

        .online-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            box-shadow: 0 0 10px #4ade80;
        }

        /* =========================================================
            NAVIGATION
        ========================================================= */

        .nav-section {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 10px;
        }

        .nav-label {
            padding: 20px 18px 8px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.28);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            margin: 2px 12px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.58);
            font-size: 13.5px;
            font-weight: 500;
            transition: all .2s ease;
            position: relative;
        }

        .nav-item i {
            font-size: 18px;
            width: 18px;
            text-align: center;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #fff;
            transform: translateX(2px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--sage), #3d5c50);
            color: #fff;
            box-shadow: 0 4px 16px rgba(92, 122, 110, 0.4);
        }

        .nav-badge {
            margin-left: auto;
            background: var(--gold);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        /* =========================================================
            FOOTER
        ========================================================= */

        .sidebar-footer {
            margin-top: auto;
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
        }

        .logout-btn {
            width: 100%;
            border: none;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.72);
            border-radius: 12px;
            padding: 12px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateY(-1px);
        }

        /* =========================================================
            MAIN
        ========================================================= */

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* =========================================================
            TOPBAR
        ========================================================= */

        .topbar {
            background: rgba(245, 240, 232, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--warm);
            height: var(--topbar-h);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--dusk);
            line-height: 1.2;
        }

        .topbar-left p {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1.5px solid var(--warm);
            border-radius: 12px;
            padding: 0 14px;
            width: 240px;
            height: 42px;
            color: var(--text-muted);
            transition: .2s;
        }

        .topbar-search:hover,
        .topbar-search:focus-within {
            border-color: var(--sage-light);
            box-shadow: 0 0 0 4px rgba(92, 122, 110, 0.08);
        }

        .topbar-search input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            color: var(--text);
            font-size: 13px;
        }

        .topbar-btn {
            width: 40px;
            height: 40px;
            background: #fff;
            border: 1.5px solid var(--warm);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: var(--text-muted);
            transition: .2s;
        }

        .topbar-btn i {
            font-size: 18px;
        }

        .topbar-btn:hover {
            background: var(--sage-pale);
            border-color: var(--sage-light);
            color: var(--sage);
            transform: translateY(-1px);
        }

        .notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 8px;
            height: 8px;
            background: var(--gold);
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* =========================================================
            PAGE BODY
        ========================================================= */

        .page-body {
            flex: 1;
            padding: 32px;
        }

        /* =========================================================
            ALERTS
        ========================================================= */

        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeUp .4s ease;
        }

        .alert i {
            font-size: 18px;
        }

        .alert-success {
            background: #edf8f1;
            border: 1px solid #b7e3c6;
            color: #2f7d4c;
        }

        .alert-error {
            background: #fff0f0;
            border: 1px solid #f6c7c7;
            color: #cc4b4b;
        }

        /* =========================================================
            CARDS
        ========================================================= */

        .card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
            animation: fadeUp .4s ease both;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 22px 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: var(--dusk);
        }

        .card-action {
            font-size: 12px;
            color: var(--sage);
            font-weight: 600;
            transition: .2s;
        }

        .card-action:hover {
            text-decoration: underline;
        }

        .card-body {
            padding: 24px;
        }

        /* =========================================================
            BUTTONS
        ========================================================= */

        .btn {
            border: none;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn i {
            font-size: 16px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--sage), #3d5c50);
            color: #fff;
            box-shadow: 0 8px 18px rgba(92, 122, 110, .2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(92, 122, 110, .3);
        }

        .btn-light {
            background: var(--cream);
            color: var(--text-muted);
        }

        .btn-light:hover {
            background: var(--sage-pale);
            color: var(--sage);
        }

        .btn-gold {
            background: var(--gold-pale);
            color: #8b6d1f;
        }

        .btn-gold:hover {
            background: #eadcae;
        }

        /* =========================================================
            TABLES
        ========================================================= */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            background: var(--cream);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 700;
            text-align: left;
            padding: 14px 18px;
        }

        table tbody td {
            padding: 16px 18px;
            font-size: 13px;
            border-top: 1px solid #f2ece3;
            color: var(--text);
        }

        table tbody tr {
            transition: .15s;
        }

        table tbody tr:hover {
            background: #fcfaf7;
        }

        /* =========================================================
            FORMS
        ========================================================= */

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--dusk);
        }

        .form-control {
            width: 100%;
            border: 1.5px solid var(--warm);
            background: #fff;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 13px;
            color: var(--text);
            outline: none;
            transition: .2s;
        }

        .form-control:focus {
            border-color: var(--sage-light);
            box-shadow: 0 0 0 4px rgba(92, 122, 110, .08);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* =========================================================
            BADGES
        ========================================================= */

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-success {
            background: #e8f5ef;
            color: #3d8c60;
        }

        .badge-warning {
            background: var(--gold-pale);
            color: #9a7c2a;
        }

        .badge-info {
            background: var(--sky-pale);
            color: #3a7a99;
        }

        .badge-danger {
            background: #fdecec;
            color: #c05a5a;
        }

        /* =========================================================
            MOBILE
        ========================================================= */

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 95;
            display: none;
        }

        .sidebar-overlay.open {
            display: block;
        }

        .mobile-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: 1.5px solid var(--warm);
            background: #fff;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
        }

        .mobile-toggle i {
            font-size: 20px;
        }

        /* =========================================================
            SCROLLBAR
        ========================================================= */

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(92, 122, 110, .25);
            border-radius: 20px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        /* =========================================================
            ANIMATION
        ========================================================= */

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

        /* =========================================================
            RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
            }

            .topbar {
                padding: 0 16px;
            }

            .topbar-search {
                display: none;
            }

            .page-body {
                padding: 20px 16px;
            }

            .topbar-left h1 {
                font-size: 18px;
            }

            .card-header,
            .card-body {
                padding-left: 18px;
                padding-right: 18px;
            }
        }
    </style>

    @yield('head')
</head>

<body>

    {{-- Mobile Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- =========================================================
    SIDEBAR
    ========================================================== --}}
    <aside class="sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="brand-pill">
                <div class="brand-icon">
                    <i class="ti ti-leaf"></i>
                </div>

                <div>
                    <div class="brand-name">eKalinga</div>
                    <div class="brand-sub">PLSP Mental Health</div>
                </div>
            </div>
        </div>

        {{-- User --}}
        <div class="sidebar-user">

            <div class="user-card">

                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="user-info">
                    <div class="user-name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="user-role">
                        {{ auth()->user()->role }}
                    </div>
                </div>

                <div class="online-dot"></div>

            </div>

        </div>

        {{-- Navigation --}}
        <nav class="nav-section">

            <div class="nav-label">Main</div>

            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard"></i>
                Dashboard
            </a>

            <a href="{{ route('feed.index') }}" class="nav-item {{ request()->routeIs('feed.*') ? 'active' : '' }}">
                <i class="ti ti-news"></i>
                Org Feed
            </a>

            <a href="{{ route('messages.index') }}"
                class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">

                <i class="ti ti-message-circle"></i>
                Messages

                @php
                    $unread = auth()->user()->unreadMessagesCount() ?? 0;
                @endphp

                @if ($unread > 0)
                    <span class="nav-badge">{{ $unread }}</span>
                @endif
            </a>

            <a href="{{ route('community.index') }}"
                class="nav-item {{ request()->routeIs('community.*') ? 'active' : '' }}">
                <i class="ti ti-users"></i>
                Community Space
            </a>

            {{-- Admin --}}
            @if (auth()->user()->isAdmin())

                <div class="nav-label">Admin</div>

                <a href="{{ route('admin.students.index') }}"
                    class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="ti ti-id-badge"></i>
                    Student Records
                </a>

                <a href="{{ route('admin.referrals.index') }}"
                    class="nav-item {{ request()->routeIs('admin.referrals.*') ? 'active' : '' }}">
                    <i class="ti ti-transfer"></i>
                    Referrals
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="ti ti-chart-bar"></i>
                    Reports & Analytics
                </a>

            @endif

            {{-- Student --}}
            @if (auth()->user()->isStudent())

                <div class="nav-label">My Records</div>

                <a href="{{ route('student.profile') }}"
                    class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i class="ti ti-user-circle"></i>
                    My Profile
                </a>

                <a href="{{ route('student.sessions') }}"
                    class="nav-item {{ request()->routeIs('student.sessions') ? 'active' : '' }}">
                    <i class="ti ti-file-text"></i>
                    Session History
                </a>

            @endif

            <div class="nav-label">Settings</div>

            <a href="{{ route('profile.edit') }}"
                class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="ti ti-settings"></i> Account Settings
            </a>
            Account Settings
            </a>

        </nav>

        {{-- Footer --}}
        <div class="sidebar-footer">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-btn">
                    <i class="ti ti-logout"></i>
                    Sign out
                </button>
            </form>

        </div>

    </aside>

    {{-- =========================================================
    MAIN
    ========================================================== --}}
    <main class="main">

        {{-- TOPBAR --}}
        <header class="topbar">

            <div style="display:flex;align-items:center;gap:14px;">

                <button class="mobile-toggle" onclick="openSidebar()">
                    <i class="ti ti-menu-2"></i>
                </button>

                <div class="topbar-left">

                    <h1>
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <p>
                        {{ now()->format('l, F d, Y') }}
                        ·
                        PLSP Center for Mental Health
                    </p>

                </div>

            </div>

            <div class="topbar-right">

                <div class="topbar-search">
                    <i class="ti ti-search"></i>
                    <input type="text" placeholder="Search records...">
                </div>

                <a href="{{ route('community.index') }}" class="topbar-btn" title="Community Space">
                    <i class="ti ti-users"></i>
                </a>

                <a href="{{ route('messages.index') }}" class="topbar-btn" title="Messages">

                    <i class="ti ti-message-circle"></i>

                    @if (isset($unread) && $unread > 0)
                        <span class="notif-dot"></span>
                    @endif

                </a>

                <a href="{{ route('profile.edit') }}" class="topbar-btn" title="Profile">
                    <i class="ti ti-user-circle"></i>
                </a>

            </div>

        </header>

        {{-- PAGE BODY --}}
        <div class="page-body">

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="ti ti-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if (session('error'))
                <div class="alert alert-error">
                    <i class="ti ti-alert-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- CONTENT --}}
            @yield('content')

        </div>

    </main>

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('open');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('open');
        }
    </script>

    @yield('scripts')

</body>

</html>