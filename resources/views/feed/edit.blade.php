```blade
@extends('dashboard.layout')
@section('title', 'Edit Post')

@section('content')

<style>

    :root{
        --primary:#185FA5;
        --primary-dark:#0C447C;
        --bg:#f4f7fb;
        --card:#ffffff;
        --border:#e5e7eb;
        --text:#111827;
        --muted:#6b7280;
        --danger:#dc2626;
        --danger-bg:#fef2f2;
        --radius:18px;
    }

    body{
        background:var(--bg);
    }

    .edit-wrapper{
        max-width:950px;
        margin:40px auto;
        padding:20px;
    }

    .edit-card{
        background:var(--card);
        border-radius:var(--radius);
        border:1px solid var(--border);
        overflow:hidden;
        box-shadow:0 15px 40px rgba(0,0,0,0.04);
    }

    .edit-header{
        background:linear-gradient(135deg,#185FA5,#0C447C);
        color:white;
        padding:30px;
    }

    .edit-header h1{
        font-size:32px;
        margin-bottom:8px;
        font-weight:700;
    }

    .edit-header p{
        opacity:.9;
        font-size:14px;
    }

    .edit-body{
        padding:30px;
    }

    .form-group{
        margin-bottom:24px;
    }

    .form-label{
        display:block;
        margin-bottom:8px;
        font-size:14px;
        font-weight:600;
        color:var(--text);
    }

    .form-control{
        width:100%;
        padding:14px 16px;
        border-radius:14px;
        border:1px solid var(--border);
        background:white;
        font-size:14px;
        color:var(--text);
        outline:none;
        transition:.2s;
    }

    .form-control:focus{
        border-color:var(--primary);
        box-shadow:0 0 0 4px rgba(24,95,165,0.10);
    }

    textarea.form-control{
        min-height:220px;
        resize:none;
        line-height:1.6;
    }

    .type-grid{
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:16px;
    }

    .type-option input{
        display:none;
    }

    .type-card{
        border:2px solid var(--border);
        border-radius:18px;
        padding:22px;
        cursor:pointer;
        transition:.2s;
        background:white;
        text-align:center;
    }

    .type-card:hover{
        border-color:var(--primary);
        transform:translateY(-2px);
    }

    .type-option input:checked + .type-card{
        border-color:var(--primary);
        background:#eff6ff;
    }

    .type-icon{
        width:58px;
        height:58px;
        border-radius:16px;
        background:#dbeafe;
        display:flex;
        align-items:center;
        justify-content:center;
        margin:auto auto 14px;
        font-size:26px;
    }

    .type-title{
        font-size:16px;
        font-weight:700;
        color:var(--text);
        margin-bottom:5px;
    }

    .type-sub{
        font-size:12px;
        color:var(--muted);
    }

    .event-fields{
        display:none;
        animation:fade .25s ease;
    }

    .event-fields.show{
        display:block;
    }

    @keyframes fade{
        from{
            opacity:0;
            transform:translateY(-8px);
        }
        to{
            opacity:1;
            transform:translateY(0);
        }
    }

    .char-count{
        margin-top:8px;
        text-align:right;
        font-size:12px;
        color:var(--muted);
    }

    .button-row{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:15px;
        margin-top:35px;
        flex-wrap:wrap;
    }

    .left-buttons,
    .right-buttons{
        display:flex;
        gap:12px;
    }

    .btn{
        padding:13px 24px;
        border:none;
        border-radius:14px;
        font-size:14px;
        font-weight:600;
        cursor:pointer;
        transition:.2s;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        justify-content:center;
    }

    .btn-secondary{
        background:#f3f4f6;
        color:#111827;
    }

    .btn-secondary:hover{
        background:#e5e7eb;
    }

    .btn-primary{
        background:var(--primary);
        color:white;
    }

    .btn-primary:hover{
        background:var(--primary-dark);
    }

    .btn-danger{
        background:var(--danger-bg);
        color:var(--danger);
    }

    .btn-danger:hover{
        background:#fee2e2;
    }

    .alert{
        padding:16px;
        border-radius:14px;
        margin-bottom:24px;
        font-size:14px;
    }

    .alert-danger{
        background:#fef2f2;
        border:1px solid #fecaca;
        color:#b91c1c;
    }

    .error-list{
        margin-top:10px;
        padding-left:20px;
    }

    .post-meta{
        display:flex;
        gap:18px;
        flex-wrap:wrap;
        margin-bottom:28px;
        padding:16px;
        border-radius:16px;
        background:#f9fafb;
        border:1px solid var(--border);
    }

    .meta-box{
        flex:1;
        min-width:160px;
    }

    .meta-label{
        font-size:12px;
        color:var(--muted);
        margin-bottom:4px;
    }

    .meta-value{
        font-size:14px;
        font-weight:600;
        color:var(--text);
    }

    @media(max-width:768px){

        .type-grid{
            grid-template-columns:1fr;
        }

        .edit-header{
            padding:24px;
        }

        .edit-body{
            padding:22px;
        }

        .button-row{
            flex-direction:column;
            align-items:stretch;
        }

        .left-buttons,
        .right-buttons{
            width:100%;
        }

        .btn{
            width:100%;
        }

    }

</style>

<div class="edit-wrapper">

    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please fix the following errors:
            </strong>

            <ul class="error-list">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="edit-card">

        <div class="edit-header">

            <h1>Edit Post</h1>

            <p>
                Update your organization announcement, event, or update post.
            </p>

        </div>

        <div class="edit-body">

            {{-- POST INFO --}}
            <div class="post-meta">

                <div class="meta-box">
                    <div class="meta-label">Created</div>
                    <div class="meta-value">
                        {{ $post->created_at->format('F d, Y h:i A') }}
                    </div>
                </div>

                <div class="meta-box">
                    <div class="meta-label">Author</div>
                    <div class="meta-value">
                        {{ $post->user->name ?? 'Unknown' }}
                    </div>
                </div>

                <div class="meta-box">
                    <div class="meta-label">Post Type</div>
                    <div class="meta-value">
                        {{ ucfirst($post->type) }}
                    </div>
                </div>

            </div>

            <form
                action="{{ route('feed.update', $post->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                {{-- TYPE --}}
                <div class="form-group">

                    <label class="form-label">
                        Select Post Type
                    </label>

                    <div class="type-grid">

                        {{-- ANNOUNCEMENT --}}
                        <label class="type-option">

                            <input
                                type="radio"
                                name="type"
                                value="announcement"
                                {{ $post->type == 'announcement' ? 'checked' : '' }}
                                onchange="toggleEventFields()"
                            >

                            <div class="type-card">

                                <div class="type-icon">
                                    📢
                                </div>

                                <div class="type-title">
                                    Announcement
                                </div>

                                <div class="type-sub">
                                    Important notices and announcements
                                </div>

                            </div>

                        </label>

                        {{-- EVENT --}}
                        <label class="type-option">

                            <input
                                type="radio"
                                name="type"
                                value="event"
                                {{ $post->type == 'event' ? 'checked' : '' }}
                                onchange="toggleEventFields()"
                            >

                            <div class="type-card">

                                <div class="type-icon">
                                    📅
                                </div>

                                <div class="type-title">
                                    Event
                                </div>

                                <div class="type-sub">
                                    Workshops, seminars, meetings
                                </div>

                            </div>

                        </label>

                        {{-- UPDATE --}}
                        <label class="type-option">

                            <input
                                type="radio"
                                name="type"
                                value="update"
                                {{ $post->type == 'update' ? 'checked' : '' }}
                                onchange="toggleEventFields()"
                            >

                            <div class="type-card">

                                <div class="type-icon">
                                    🔄
                                </div>

                                <div class="type-title">
                                    Update
                                </div>

                                <div class="type-sub">
                                    Organization updates and changes
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

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        maxlength="120"
                        placeholder="Enter title..."
                        value="{{ old('title', $post->title) }}"
                    >

                </div>

                {{-- BODY --}}
                <div class="form-group">

                    <label class="form-label">
                        Post Content
                    </label>

                    <textarea
                        name="body"
                        id="body"
                        class="form-control"
                        maxlength="1000"
                        required
                        oninput="updateCounter()"
                    >{{ old('body', $post->body) }}</textarea>

                    <div class="char-count">
                        <span id="counter">0</span> / 1000
                    </div>

                </div>

                {{-- EVENT FIELDS --}}
                <div
                    id="eventFields"
                    class="event-fields"
                >

                    <div class="form-group">

                        <label class="form-label">
                            Event Date & Time
                        </label>

                        <input
                            type="text"
                            name="event_date"
                            class="form-control"
                            placeholder="Example: June 28, 2025 · 8:00 AM"
                            value="{{ old('event_date', $post->event_date) }}"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Event Location
                        </label>

                        <input
                            type="text"
                            name="event_location"
                            class="form-control"
                            placeholder="Example: AVR Room 302"
                            value="{{ old('event_location', $post->event_location) }}"
                        >

                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="button-row">

                    <div class="left-buttons">

                        <a
                            href="{{ route('feed.index') }}"
                            class="btn btn-secondary"
                        >
                            Cancel
                        </a>

                    </div>

                    <div class="right-buttons">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Update Post
                        </button>

                    </div>

                </div>

            </form>

            {{-- DELETE --}}
            <form
                action="{{ route('feed.destroy', $post->id) }}"
                method="POST"
                style="margin-top:20px;"
                onsubmit="return confirm('Are you sure you want to delete this post?')"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-danger"
                >
                    Delete Post
                </button>

            </form>

        </div>

    </div>

</div>

<script>

    function toggleEventFields(){

        const selected =
            document.querySelector('input[name="type"]:checked').value;

        const fields =
            document.getElementById('eventFields');

        if(selected === 'event'){
            fields.classList.add('show');
        }else{
            fields.classList.remove('show');
        }

    }

    function updateCounter(){

        const body =
            document.getElementById('body');

        const counter =
            document.getElementById('counter');

        counter.innerText = body.value.length;

    }

    window.onload = function(){

        toggleEventFields();
        updateCounter();

    }

</script>

@endsection
```
