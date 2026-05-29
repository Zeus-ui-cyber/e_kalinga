```blade
@extends('dashboard.layout')
@section('title', 'Create Post')

@section('content')

    <style>
        :root {
            --primary: #185FA5;
            --primary-dark: #0C447C;
            --bg: #f5f7fb;
            --card: #ffffff;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --success: #16a34a;
            --radius: 18px;
        }

        body {
            background: var(--bg);
        }

        .create-wrapper {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .create-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        }

        .create-header {
            padding: 30px;
            background: linear-gradient(135deg, #185FA5, #0C447C);
            color: white;
        }

        .create-header h1 {
            font-size: 30px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .create-header p {
            opacity: .9;
            font-size: 14px;
        }

        .create-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .form-control {
            width: 100%;
            border: 1px solid var(--border);
            background: #fff;
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 14px;
            outline: none;
            transition: .2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(24, 95, 165, 0.10);
        }

        textarea.form-control {
            min-height: 180px;
            resize: none;
            line-height: 1.6;
        }

        .type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .type-option {
            position: relative;
        }

        .type-option input {
            display: none;
        }

        .type-card {
            border: 2px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: .2s;
            text-align: center;
            background: #fff;
        }

        .type-card:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
        }

        .type-option input:checked+.type-card {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .type-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: #dbeafe;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto auto 12px;
            font-size: 24px;
        }

        .type-title {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .type-sub {
            font-size: 12px;
            color: var(--muted);
        }

        .event-fields {
            display: none;
            animation: fade .25s ease;
        }

        .event-fields.show {
            display: block;
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .char-counter {
            margin-top: 8px;
            text-align: right;
            font-size: 12px;
            color: var(--muted);
        }

        .btn-row {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            border: none;
            border-radius: 14px;
            padding: 13px 22px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .error-list {
            padding-left: 18px;
            margin-top: 10px;
        }

        @media(max-width:768px) {

            .type-grid {
                grid-template-columns: 1fr;
            }

            .create-header {
                padding: 24px;
            }

            .create-body {
                padding: 22px;
            }

        }
    </style>

    <div class="create-wrapper">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There were some problems with your input.</strong>

                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="create-card">

            <div class="create-header">
                <h1>Create New Post</h1>
                <p>Share announcements, events, and updates with your organization members.</p>
            </div>

            <div class="create-body">

                <form action="{{ route('feed.store') }}" method="POST">

                    @csrf

                    {{-- POST TYPE --}}
                    <div class="form-group">

                        <label class="form-label">
                            Select Post Type
                        </label>

                        <div class="type-grid">

                            <label class="type-option">

                                <input type="radio" name="type" value="announcement" checked onchange="toggleEventFields()">

                                <div class="type-card">
                                    <div class="type-icon">
                                        📢
                                    </div>

                                    <div class="type-title">
                                        Announcement
                                    </div>

                                    <div class="type-sub">
                                        Important organization notices
                                    </div>
                                </div>

                            </label>

                            <label class="type-option">

                                <input type="radio" name="type" value="event" onchange="toggleEventFields()">

                                <div class="type-card">
                                    <div class="type-icon">
                                        📅
                                    </div>

                                    <div class="type-title">
                                        Event
                                    </div>

                                    <div class="type-sub">
                                        Workshops, meetings, hackathons
                                    </div>
                                </div>

                            </label>

                            <label class="type-option">

                                <input type="radio" name="type" value="update" onchange="toggleEventFields()">

                                <div class="type-card">
                                    <div class="type-icon">
                                        🔄
                                    </div>

                                    <div class="type-title">
                                        Update
                                    </div>

                                    <div class="type-sub">
                                        Organization changes and updates
                                    </div>
                                </div>

                            </label>

                        </div>

                    </div>

                    {{-- TITLE --}}
                    <div class="form-group">

                        <label class="form-label">
                            Post Title
                        </label>

                        <input type="text" name="title" class="form-control" placeholder="Enter title..." maxlength="120"
                            value="{{ old('title') }}">

                    </div>

                    {{-- BODY --}}
                    <div class="form-group">

                        <label class="form-label">
                            Post Content
                        </label>

                        <textarea name="body" id="body" class="form-control" placeholder="Write your content here..."
                            maxlength="1000" required oninput="updateCounter()">{{ old('body') }}</textarea>

                        <div class="char-counter">
                            <span id="counter">0</span> / 1000
                        </div>

                    </div>

                    {{-- EVENT FIELDS --}}
                    <div id="eventFields" class="event-fields">

                        <div class="form-group">

                            <label class="form-label">
                                Event Date & Time
                            </label>

                            <input type="text" name="event_date" class="form-control"
                                placeholder="Example: June 28, 2025 · 8:00 AM" value="{{ old('event_date') }}">

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                Event Location
                            </label>

                            <input type="text" name="event_location" class="form-control"
                                placeholder="Example: AVR Room 302" value="{{ old('event_location') }}">

                        </div>

                    </div>

                    {{-- BUTTONS --}}
                    <div class="btn-row">

                        <a href="{{ route('feed.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Publish Post
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>

        function toggleEventFields() {

            const selectedType =
                document.querySelector('input[name="type"]:checked').value;

            const eventFields =
                document.getElementById('eventFields');

            if (selectedType === 'event') {
                eventFields.classList.add('show');
            } else {
                eventFields.classList.remove('show');
            }

        }

        function updateCounter() {

            const body =
                document.getElementById('body');

            const counter =
                document.getElementById('counter');

            counter.innerText = body.value.length;

        }

        window.onload = function () {

            toggleEventFields();
            updateCounter();

        }

    </script>

@endsection
```