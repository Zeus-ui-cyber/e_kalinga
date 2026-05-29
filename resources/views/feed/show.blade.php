{{-- resources/views/feed/show.blade.php --}}

@extends('dashboard.layout')
@section('title', 'View Post')

@section('content')

    <style>
        :root {
            --primary: #185FA5;
            --primary-dark: #0C447C;
            --primary-light: #E6F1FB;

            --green: #3B6D11;
            --green-light: #EAF3DE;

            --amber: #854F0B;
            --amber-light: #FAEEDA;

            --bg: #f5f7fb;
            --card: #ffffff;
            --text: #1a1a18;
            --muted: #6b6b66;
            --border: #e5e7eb;

            --radius: 18px;
        }

        body {
            background: var(--bg);
        }

        .feed-wrapper {
            max-width: 900px;
            margin: auto;
            padding: 30px 20px;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 12px;
            background: white;
            border: 1px solid var(--border);
            color: var(--text);
            text-decoration: none;
            transition: .2s;
            font-weight: 600;
        }

        .btn-back:hover {
            background: #f3f4f6;
        }

        .post-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        }

        .post-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            flex-shrink: 0;
        }

        .post-meta {
            flex: 1;
        }

        .author {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }

        .date {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            margin-top: 10px;
        }

        .badge-announcement {
            background: var(--primary-light);
            color: var(--primary);
        }

        .badge-event {
            background: var(--green-light);
            color: var(--green);
        }

        .badge-update {
            background: var(--amber-light);
            color: var(--amber);
        }

        .post-body {
            padding: 30px;
        }

        .post-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .post-content {
            font-size: 16px;
            line-height: 1.9;
            color: #374151;
            white-space: pre-line;
        }

        .event-box {
            margin-top: 25px;
            padding: 18px;
            border-radius: 16px;
            background: #f9fafb;
            border-left: 5px solid var(--green);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .event-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #374151;
            font-size: 15px;
        }

        .event-item i {
            color: var(--green);
            font-size: 18px;
        }

        .post-footer {
            border-top: 1px solid var(--border);
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .footer-info {
            font-size: 14px;
            color: var(--muted);
        }

        .footer-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            border-radius: 12px;
            padding: 11px 18px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-edit {
            background: var(--primary);
            color: white;
        }

        .btn-edit:hover {
            background: var(--primary-dark);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .btn-feed {
            background: #111827;
            color: white;
        }

        .btn-feed:hover {
            background: black;
        }

        @media(max-width:768px) {

            .post-title {
                font-size: 25px;
            }

            .post-header,
            .post-body,
            .post-footer {
                padding: 20px;
            }

            .footer-actions {
                width: 100%;
            }

            .btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">

    <div class="feed-wrapper">

        <div class="top-actions">

            <div class="page-title">
                Feed Post
            </div>

            <a href="{{ route('feed.index') }}" class="btn-back">
                <i class="ti ti-arrow-left"></i>
                Back to Feed
            </a>

        </div>

        <div class="post-card">

            <div class="post-header">

                <div class="avatar">
                    {{ strtoupper(substr($post->user->name ?? 'U', 0, 2)) }}
                </div>

                <div class="post-meta">

                    <div class="author">
                        {{ $post->user->name ?? 'Unknown User' }}
                    </div>

                    <div class="date">
                        Posted {{ $post->created_at->diffForHumans() }}
                    </div>

                    @if($post->type == 'announcement')
                        <div class="badge badge-announcement">
                            <i class="ti ti-speakerphone"></i>
                            Announcement
                        </div>
                    @elseif($post->type == 'event')
                        <div class="badge badge-event">
                            <i class="ti ti-calendar-event"></i>
                            Event
                        </div>
                    @else
                        <div class="badge badge-update">
                            <i class="ti ti-refresh"></i>
                            Update
                        </div>
                    @endif

                </div>

            </div>

            <div class="post-body">

                @if($post->title)
                    <div class="post-title">
                        {{ $post->title }}
                    </div>
                @endif

                <div class="post-content">
                    {{ $post->body }}
                </div>

                @if($post->type === 'event')

                    <div class="event-box">

                        @if($post->event_date)
                            <div class="event-item">
                                <i class="ti ti-calendar"></i>
                                {{ $post->event_date }}
                            </div>
                        @endif

                        @if($post->event_location)
                            <div class="event-item">
                                <i class="ti ti-map-pin"></i>
                                {{ $post->event_location }}
                            </div>
                        @endif

                    </div>

                @endif

            </div>

            <div class="post-footer">

                <div class="footer-info">
                    Last updated:
                    {{ $post->updated_at->format('F d, Y h:i A') }}
                </div>

                <div class="footer-actions">

                    <a href="{{ route('feed.index') }}" class="btn btn-feed">
                        <i class="ti ti-layout-list"></i>
                        Feed
                    </a>

                    <a href="{{ route('feed.edit', $post->id) }}" class="btn btn-edit">
                        <i class="ti ti-edit"></i>
                        Edit
                    </a>

                    <form action="{{ route('feed.destroy', $post->id) }}" method="POST"
                        onsubmit="return confirm('Delete this post?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-delete">
                            <i class="ti ti-trash"></i>
                            Delete
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection