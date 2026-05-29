{{-- COMPOSE CARD (Admin Only) --}}
<div class="compose-card">
    <form action="{{ route('feed.store') }}" method="POST">
        @csrf
        <textarea name="body" placeholder="What's happening?" required
            style="width: 100%; border: none; background: transparent; resize: none; outline: none;"></textarea>

        <input type="hidden" name="type" value="announcement">

        <button type="submit" class="btn btn-primary">Post</button>
    </form>
</div>

{{-- TOP ROW --}}
<div class="compose-top">

    {{-- USER AVATAR --}}
    <div class="user-av" id="compose-av" style="background: {{ auth()->user()->color ?? '#185FA5' }};
                color: {{ auth()->user()->text_color ?? '#E6F1FB' }};">
        {{ auth()->user()->initials ?? 'AD' }}
    </div>

    {{-- CLICK TO OPEN --}}
    <div class="compose-trigger" id="compose-trigger" onclick="openCompose()">
        Share an announcement, event, or update…
    </div>

</div>

{{-- TYPE SELECTOR --}}
<div class="type-chips" id="type-chips">

    <button type="button" class="type-chip active-ann" id="chip-ann" onclick="selectType('announcement')">
        <i class="ti ti-speakerphone"></i> Announcement
    </button>

    <button type="button" class="type-chip" id="chip-evt" onclick="selectType('event')">
        <i class="ti ti-calendar-event"></i> Event
    </button>

    <button type="button" class="type-chip" id="chip-upd" onclick="selectType('update')">
        <i class="ti ti-refresh"></i> Update
    </button>

</div>

{{-- FORM --}}
<form id="compose-form" class="compose-form" method="POST" action="{{ route('feed.store') }}">

    @csrf

    {{-- TITLE --}}
    <input type="text" name="title" id="post-title-inp" placeholder="Title (optional)" maxlength="120">

    {{-- BODY --}}
    <textarea name="body" id="post-body-inp" rows="4" placeholder="Write something for your members…" maxlength="1000"
        oninput="updateCharCount()"></textarea>

    {{-- EVENT FIELDS --}}
    <div class="compose-event-fields" id="event-fields">

        <input type="text" name="event_date" id="event-date-inp"
            placeholder="📅 Date & time — e.g. June 28, 2025 · 8:00 AM">

        <input type="text" name="event_location" id="event-loc-inp"
            placeholder="📍 Location — e.g. Auditorium, Main Building">

    </div>

    {{-- ACTIONS --}}
    <div class="compose-actions">

        <span class="char-count" id="char-count">0 / 1000</span>

        <button type="button" class="btn btn-ghost" onclick="closeCompose()">
            Cancel
        </button>

        {{-- TYPE (hidden for backend) --}}
        <input type="hidden" name="type" id="compose-type" value="announcement">

        <button type="submit" class="btn btn-primary" id="post-btn" disabled>
            Post
        </button>

    </div>

</form>

</div>