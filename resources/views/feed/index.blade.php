{{-- resources/views/feed/index.blade.php --}}
@extends('dashboard.layout')

@section('title', 'Organization Feed')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css" />

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f4f4f3;
            --bg-tertiary: #eeeee9;
            --text-primary: #1a1a18;
            --text-secondary: #6b6b66;
            --text-tertiary: #9a9a94;
            --border-light: rgba(0, 0, 0, 0.10);
            --border-mid: rgba(0, 0, 0, 0.18);
            --accent: #185FA5;
            --accent-light: #E6F1FB;
            --accent-dark: #0C447C;
            --green: #3B6D11;
            --green-light: #EAF3DE;
            --amber: #854F0B;
            --amber-light: #FAEEDA;
            --coral: #993556;
            --coral-light: #FBEAF0;
            --danger: #D85A30;
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --font: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }

        /* TOP NAV */
        .topnav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-light);
            padding: 0 1.5rem;
            height: 56px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topnav-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 15px;
            color: var(--text-primary);
            text-decoration: none;
        }

        .topnav-logo-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-md);
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .topnav-spacer {
            flex: 1;
        }

        .topnav-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* PAGE */
        .page-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem;
            display: grid;
            grid-template-columns: 250px 1fr 240px;
            gap: 20px;
        }

        /* SIDEBARS */
        .sidebar-left,
        .sidebar-right {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* CARDS */
        .card {
            background: var(--bg-primary);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        /* ORG */
        .org-banner {
            height: 70px;
            background: linear-gradient(135deg, #185FA5, #0C447C);
        }

        .org-body {
            padding: 1rem;
        }

        .org-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--accent);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-top: -38px;
            border: 4px solid white;
        }

        .org-name {
            margin-top: 10px;
            font-size: 15px;
            font-weight: 600;
        }

        .org-sub {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-bottom: 14px;
        }

        .org-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .stat-box {
            background: var(--bg-secondary);
            border-radius: 10px;
            text-align: center;
            padding: 8px;
        }

        .stat-num {
            font-size: 16px;
            font-weight: 700;
        }

        .stat-lbl {
            font-size: 11px;
            color: var(--text-tertiary);
        }

        /* NAV */
        .nav-card {
            padding: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-secondary);
            transition: .2s;
            font-size: 14px;
        }

        .nav-item:hover,
        .nav-item.active {
            background: var(--accent-light);
            color: var(--accent);
        }

        /* FEED */
        .feed-center {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .filter-bar {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-btn {
            border: 1px solid var(--border-light);
            background: white;
            padding: 7px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
        }

        .filter-btn.active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        /* COMPOSE */
        .compose-card {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            padding: 1rem;
        }

        .compose-top {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
        }

        .user-av {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .compose-form textarea,
        .compose-form input {
            width: 100%;
            background: var(--bg-secondary);
            border: 1px solid var(--border-light);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .compose-form textarea {
            resize: none;
            min-height: 120px;
        }

        .compose-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 8px 18px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-secondary {
            background: var(--bg-secondary);
        }

        /* POSTS */
        .post-card {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .post-header {
            display: flex;
            gap: 10px;
            padding: 1rem 1rem 0.5rem;
        }

        .post-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--accent);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .post-meta {
            flex: 1;
        }

        .post-author {
            font-size: 14px;
            font-weight: 600;
        }

        .post-time {
            font-size: 12px;
            color: var(--text-tertiary);
        }

        .post-body {
            padding: 0 1rem 1rem;
        }

        .post-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .post-text {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.7;
            white-space: pre-line;
        }

        .post-actions {
            display: flex;
            gap: 10px;
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--border-light);
        }

        .action-btn {
            border: none;
            background: transparent;
            cursor: pointer;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
        }

        /* RIGHT */
        .widget-card {
            padding: 1rem;
        }

        .widget-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .event-item,
        .member-item {
            margin-bottom: 12px;
        }

        .member-name {
            font-size: 13px;
            font-weight: 600;
        }

        .member-role {
            font-size: 11px;
            color: var(--text-tertiary);
        }

        /* RESPONSIVE */
        @media(max-width: 1000px) {
            .page-wrap {
                grid-template-columns: 220px 1fr;
            }

            .sidebar-right {
                display: none;
            }
        }

        @media(max-width: 768px) {
            .page-wrap {
                grid-template-columns: 1fr;
            }

            .sidebar-left {
                display: none;
            }
        }
    </style>

    <!-- TOP NAV -->
    <nav class="topnav">
        <a href="#" class="topnav-logo">
            <div class="topnav-logo-icon">
                <i class="ti ti-device-desktop"></i>
            </div>
            CS Society
        </a>

        <div class="topnav-spacer"></div>

        <div class="topnav-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
        </div>
    </nav>

    <div class="page-wrap">

        <!-- LEFT -->
        <aside class="sidebar-left">

            <div class="card">
                <div class="org-banner"></div>

                <div class="org-body">
                    <div class="org-avatar">
                        CS
                    </div>

                    <div class="org-name">
                        Computer Society
                    </div>

                    <div class="org-sub">
                        University Student Organization
                    </div>

                    <div class="org-stats">
                        <div class="stat-box">
                            <div class="stat-num">
                                {{ $posts->count() }}
                            </div>
                            <div class="stat-lbl">Posts</div>
                        </div>

                        <div class="stat-box">
                            <div class="stat-num">248</div>
                            <div class="stat-lbl">Members</div>
                        </div>

                        <div class="stat-box">
                            <div class="stat-num">12</div>
                            <div class="stat-lbl">Events</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card nav-card">
                <a href="#" class="nav-item active">
                    <i class="ti ti-layout-list"></i>
                    Feed
                </a>

                <a href="#" class="nav-item">
                    <i class="ti ti-calendar-event"></i>
                    Events
                </a>

                <a href="#" class="nav-item">
                    <i class="ti ti-users"></i>
                    Members
                </a>

                <a href="#" class="nav-item">
                    <i class="ti ti-photo"></i>
                    Gallery
                </a>
            </div>

        </aside>

        <!-- CENTER -->
        <main class="feed-center">

            <!-- FILTER -->
            <div class="filter-bar">
                <button class="filter-btn active">All Posts</button>
                <button class="filter-btn">Announcements</button>
                <button class="filter-btn">Events</button>
                <button class="filter-btn">Updates</button>
            </div>

            <!-- COMPOSE -->
            @if(Auth::user()->role == 'admin')
                <div class="compose-card">

                    <div class="compose-top">
                        <div class="user-av">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>

                        <div>
                            <strong>{{ Auth::user()->name }}</strong><br>
                            <small style="color:gray">Organization Admin</small>
                        </div>
                    </div>

                    <form action="{{ route('feed.store') }}" method="POST" class="compose-form"> @csrf

                        <input type="text" name="title" placeholder="Post title">

                        <textarea name="body" placeholder="Share an announcement, event, or update..." required></textarea>

                        <input type="text" name="event_date" placeholder="Event date (optional)">

                        <input type="text" name="event_location" placeholder="Event location (optional)">

                        <div class="compose-actions">
                            <button type="reset" class="btn btn-secondary">
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-primary">
                                Publish
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- POSTS -->
            @forelse($posts as $post)

                <div class="post-card">

                    <div class="post-header">

                        <div class="post-avatar">
                            {{ strtoupper(substr($post->user->name, 0, 2)) }}
                        </div>

                        <div class="post-meta">
                            <div class="post-author">
                                {{ $post->user->name }}
                            </div>

                            <div class="post-time">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>

                    </div>

                    <div class="post-body">

                        @if($post->title)
                            <div class="post-title">
                                {{ $post->title }}
                            </div>
                        @endif

                        <div class="post-text">
                            {{ $post->body }}
                        </div>

                        @if($post->event_date || $post->event_location)
                            <div style="margin-top:14px;padding:12px;background:var(--bg-secondary);border-radius:10px;">
                                @if($post->event_date)
                                    <div style="margin-bottom:6px;">
                                        <i class="ti ti-calendar"></i>
                                        {{ $post->event_date }}
                                    </div>
                                @endif

                                @if($post->event_location)
                                    <div>
                                        <i class="ti ti-map-pin"></i>
                                        {{ $post->event_location }}
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>

                    <div class="post-actions">

                        <button class="action-btn">
                            <i class="ti ti-heart"></i>
                            Like
                        </button>

                        <button class="action-btn">
                            <i class="ti ti-message-circle"></i>
                            Comment
                        </button>

                        <button class="action-btn">
                            <i class="ti ti-share"></i>
                            Share
                        </button>

                    </div>

                </div>

            @empty

                <div class="card" style="padding:3rem;text-align:center;">
                    <i class="ti ti-inbox" style="font-size:40px;color:gray"></i>

                    <h3 style="margin-top:10px;">
                        No posts available
                    </h3>

                    <p style="color:gray;">
                        Create your first organization post.
                    </p>
                </div>

            @endforelse

        </main>

        <!-- RIGHT -->
        <aside class="sidebar-right">

            <div class="card widget-card">

                <div class="widget-title">
                    Upcoming Events
                </div>

                <div class="event-item">
                    <strong>Web Dev Workshop</strong><br>
                    <small>June 20 · Room 302</small>
                </div>

                <div class="event-item">
                    <strong>Hackathon 2025</strong><br>
                    <small>June 28 · Auditorium</small>
                </div>

                <div class="event-item">
                    <strong>General Assembly</strong><br>
                    <small>July 5 · AVR</small>
                </div>

            </div>

            <div class="card widget-card">

                <div class="widget-title">
                    Active Members
                </div>

                <div class="member-item">
                    <div class="member-name">Juan Dela Cruz</div>
                    <div class="member-role">Developer</div>
                </div>

                <div class="member-item">
                    <div class="member-name">Rina Cruz</div>
                    <div class="member-role">Designer</div>
                </div>

                <div class="member-item">
                    <div class="member-name">Paolo Reyes</div>
                    <div class="member-role">Secretary</div>
                </div>

            </div>

        </aside>

    </div>

@endsection