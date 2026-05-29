<aside class="sidebar-left">

    {{-- ORG CARD --}}
    <div class="org-card">

        <div class="org-banner"></div>

        <div class="org-card-body">

            <div class="org-avatar-wrap">
                <div class="org-avatar">
                    CS
                </div>
            </div>

            <div class="org-name">Computer Society</div>
            <div class="org-sub">University Student Organization</div>

            <div class="org-stats">
                <div class="stat-box">
                    <span class="stat-num">{{ $postCount ?? 0 }}</span>
                    <span class="stat-lbl">posts</span>
                </div>

                <div class="stat-box">
                    <span class="stat-num">{{ $memberCount ?? 0 }}</span>
                    <span class="stat-lbl">members</span>
                </div>

                <div class="stat-box">
                    <span class="stat-num">{{ $eventCount ?? 0 }}</span>
                    <span class="stat-lbl">events</span>
                </div>
            </div>

        </div>
    </div>

    {{-- NAVIGATION --}}
    <nav class="nav-card">

        <a href="{{ route('feed.index') }}" class="nav-item {{ request()->routeIs('feed.*') ? 'active' : '' }}">
            <i class="ti ti-layout-list"></i> Feed
        </a>

        <a href="{{ route('community.index') }}"
            class="nav-item {{ request()->routeIs('community.*') ? 'active' : '' }}">
            <i class="ti ti-message-circle"></i> Community
        </a>

        <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
            <i class="ti ti-users"></i> Messages
        </a>

        <a href="#" class="nav-item">
            <i class="ti ti-photo"></i> Gallery
        </a>

        {{-- ADMIN ONLY --}}
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.feed.create') }}" class="nav-item admin-el">
                <i class="ti ti-plus"></i> Create Post
            </a>

            <a href="{{ route('admin.reports.index') }}" class="nav-item admin-el">
                <i class="ti ti-chart-bar"></i> Reports
            </a>

            <a href="{{ route('admin.students.index') }}" class="nav-item admin-el">
                <i class="ti ti-settings"></i> Manage Students
            </a>
        @endif

    </nav>

</aside>