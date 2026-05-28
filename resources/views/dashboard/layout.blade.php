<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eKalinga — @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #0f5c42;
            --green-dark: #0a3d2e;
            --green-light: #f0fdf4;
            --sidebar-w: 240px;
            --topbar-h: 60px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f5;
            color: #111827;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(170deg, #0a3d2e 0%, #0f5c42 100%);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-logo-icon {
            width: 34px;
            height: 34px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo-name {
            font-size: 17px;
            font-weight: 700;
            color: #fff;
        }

        .sidebar-logo-sub {
            font-size: 9px;
            color: rgba(255, 255, 255, 0.45);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-top: 1px;
        }

        /* Role badge */
        .role-badge {
            margin: 12px 16px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .role-info {
            flex: 1;
            min-width: 0;
        }

        .role-name {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .role-label {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .role-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #4ade80;
            flex-shrink: 0;
        }

        /* Nav sections */
        .nav-section {
            padding: 8px 0;
            flex: 1;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 10px 20px 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 0;
            transition: all 0.15s;
            position: relative;
        }

        .nav-item i {
            font-size: 17px;
            flex-shrink: 0;
        }

        .nav-item:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-item.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #4ade80;
            border-radius: 0 2px 2px 0;
        }

        .nav-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
        }

        /* Sidebar footer */
        .sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 12px 16px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 9px 12px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.6);
            background: transparent;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.15s;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .logout-btn i {
            font-size: 17px;
        }

        /* ── Top bar ── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 24px;
            z-index: 99;
            gap: 12px;
        }

        .topbar-hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: #6b7280;
            cursor: pointer;
        }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            flex: 1;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: background 0.15s;
            color: #6b7280;
            font-size: 17px;
            text-decoration: none;
        }

        .topbar-btn:hover {
            background: #f9fafb;
            color: #111827;
        }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 7px;
            height: 7px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
        }

        .page-body {
            padding: 28px 28px;
        }

        /* ── Cards & widgets ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        .stat-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .stat-card-value {
            font-size: 26px;
            font-weight: 700;
            color: #111827;
        }

        .stat-card-sub {
            font-size: 12px;
            color: #9ca3af;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .card-body {
            padding: 20px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #374151;
            cursor: pointer;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-sm:hover {
            background: #f9fafb;
        }

        .btn-primary {
            background: var(--green);
            color: #fff;
            border-color: var(--green);
        }

        .btn-primary:hover {
            background: var(--green-dark);
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 99;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .topbar {
                left: 0;
            }

            .topbar-hamburger {
                display: flex;
            }

            .main-content {
                margin-left: 0;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .page-body {
                padding: 20px 16px;
            }
        }
    </style>
    @yield('head')
</head>

<body>

    {{-- Sidebar overlay (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- ── Sidebar ── --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo --}}
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg width="18" height="18" viewBox="0 0 22 22" fill="none">
                    <path d="M11 2C11 2 4 7 4 12.5C4 16.09 7.13 19 11 19C14.87 19 18 16.09 18 12.5C18 7 11 2 11 2Z"
                        fill="rgba(255,255,255,0.9)" />
                    <circle cx="11" cy="12.5" r="2.8" fill="#0f5c42" />
                </svg>
            </div>
            <div>
                <div class="sidebar-logo-name">eKalinga</div>
                <div class="sidebar-logo-sub">Mental Health Portal</div>
            </div>
        </div>

        {{-- User info --}}
        <div class="role-badge">
            <div class="role-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="role-info">
                <div class="role-name">{{ auth()->user()->name }}</div>
                <div class="role-label">{{ auth()->user()->role }}</div>
            </div>
            <div class="role-dot"></div>
        </div>

        {{-- Navigation --}}
        <nav class="nav-section">

            {{-- Common nav items --}}
            <div class="nav-section-label">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard"></i> Dashboard
            </a>
            <a href="{{ route('feed.index') }}" class="nav-item {{ request()->routeIs('feed.*') ? 'active' : '' }}">
                <i class="ti ti-news"></i> Org Feed
            </a>
            <a href="{{ route('messages.index') }}"
                class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <i class="ti ti-message-circle"></i> Messages
                {{-- Unread count badge --}}
                @php $unread = auth()->user()->unreadMessagesCount() ?? 0; @endphp
                @if ($unread > 0)
                    <span class="nav-badge">{{ $unread }}</span>
                @endif
            </a>

            {{-- Admin-only nav items --}}
            @if (auth()->user()->isAdmin())
                <div class="nav-section-label">Admin</div>
                <a href="{{ route('admin.students.index') }}"
                    class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="ti ti-users"></i> Student Records
                </a>
                <a href="{{ route('admin.referrals.index') }}"
                    class="nav-item {{ request()->routeIs('admin.referrals.*') ? 'active' : '' }}">
                    <i class="ti ti-transfer"></i> Referrals
                </a>
                <a href="{{ route('admin.reports.index') }}"
                    class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="ti ti-chart-bar"></i> Reports & Analytics
                </a>
            @endif

            {{-- Student-only nav items --}}
            @if (auth()->user()->isStudent())
                <div class="nav-section-label">My Records</div>
                <a href="{{ route('student.profile') }}"
                    class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i class="ti ti-user-circle"></i> My Profile
                </a>
                <a href="{{ route('student.sessions') }}"
                    class="nav-item {{ request()->routeIs('student.sessions') ? 'active' : '' }}">
                    <i class="ti ti-file-text"></i> Session History
                </a>
            @endif

            <div class="nav-section-label">Settings</div>
            <a href="{{ route('profile.edit') }}"
                class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="ti ti-settings"></i> Account Settings
            </a>

        </nav>

        {{-- Logout --}}
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="ti ti-logout"></i> Sign out
                </button>
            </form>
        </div>

    </aside>

    {{-- ── Top bar ── --}}
    <header class="topbar">
        <button class="topbar-hamburger" onclick="openSidebar()">
            <i class="ti ti-menu-2"></i>
        </button>

        <span class="topbar-title">@yield('page-title', 'Dashboard')</span>

        <div class="topbar-actions">
            <a href="{{ route('messages.index') }}" class="topbar-btn" title="Messages">
                <i class="ti ti-message-circle"></i>
                @if (isset($unread) && $unread > 0)
                    <span class="notif-dot"></span>
                @endif
            </a>
            <a href="{{ route('profile.edit') }}" class="topbar-btn" title="Account">
                <i class="ti ti-user-circle"></i>
            </a>
        </div>
    </header>

    {{-- ── Page content ── --}}
    <main class="main-content">
        <div class="page-body">

            {{-- Flash messages --}}
            @if (session('success'))
                <div
                    style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 16px;font-size:13px;color:#15803d;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                    <i class="ti ti-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div
                    style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 16px;font-size:13px;color:#dc2626;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                    <i class="ti ti-alert-circle"></i> {{ session('error') }}
                </div>
            @endif

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