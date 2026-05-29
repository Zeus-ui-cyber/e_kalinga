<div class="post-card" id="post-{{ $post->id }}">

    <div class="post-header">
        <div class="post-av">
            {{ $post->user->initials }}
        </div>

        <div class="post-meta">
            <div class="post-author-row">
                <span class="post-author">{{ $post->user->name }}</span>

                <span class="post-badge">
                    {{ ucfirst($post->type) }}
                </span>
            </div>

            <div class="post-byline">
                {{ $post->created_at->diffForHumans() }}
            </div>
        </div>
    </div>

    <div class="post-body">
        @if($post->title)
            <div class="post-title">{{ $post->title }}</div>
        @endif

        <div class="post-text">
            {{ $post->body }}
        </div>

        @if($post->event_date || $post->event_location)
            <div class="event-block">
                @if($post->event_date)
                    <div class="event-field">📅 {{ $post->event_date }}</div>
                @endif

                @if($post->event_location)
                    <div class="event-field">📍 {{ $post->event_location }}</div>
                @endif
            </div>
        @endif
    </div>

</div>