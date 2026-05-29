@extends('dashboard.layout')

@section('title', 'Community Space')
@section('page-title', 'Community Space')

@section('head')
    <style>
        .chat-wrap {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 120px);
            max-width: 760px;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .chat-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .chat-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0f5c42, #1a7a58);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Member chips strip */
        .members-strip {
            padding: 10px 20px;
            border-bottom: 1px solid #f0f0f0;
            background: #fff;
            flex-shrink: 0;
        }

        .members-label {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 6px;
        }

        .members-chips {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            scrollbar-width: none;
            padding-bottom: 2px;
        }

        .members-chips::-webkit-scrollbar {
            display: none;
        }

        .member-chip {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #374151;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 3px 10px;
            border-radius: 12px;
            white-space: nowrap;
        }

        .member-chip .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dot-online {
            background: #16a34a;
        }

        .dot-offline {
            background: #d1d5db;
        }

        /* Chat body */
        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #f9fafb;
        }

        /* Message row */
        .msg-row {
            display: flex;
            gap: 8px;
            align-items: flex-end;
        }

        .msg-row.mine {
            flex-direction: row-reverse;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .bubble-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
            max-width: 68%;
        }

        .msg-row.mine .bubble-group {
            align-items: flex-end;
        }

        .sender-name {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 2px;
            padding: 0 4px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .msg-row.mine .sender-name {
            justify-content: flex-end;
        }

        .facilitator-badge {
            font-size: 10px;
            color: #15803d;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 1px 6px;
            border-radius: 8px;
            font-weight: 600;
        }

        .anon-badge {
            font-size: 10px;
            color: #9ca3af;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 1px 6px;
            border-radius: 8px;
        }

        .bubble {
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.5;
            word-break: break-word;
        }

        .bubble.mine {
            background: #0f5c42;
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .bubble.theirs {
            background: #fff;
            color: #111827;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 4px;
        }

        .bubble.facilitator {
            background: #f0fdf4;
            color: #111827;
            border: 1px solid #bbf7d0;
            border-bottom-left-radius: 4px;
        }

        .bubble-meta {
            font-size: 11px;
            margin-top: 3px;
            color: #9ca3af;
            padding: 0 4px;
        }

        .msg-row.mine .bubble-meta {
            text-align: right;
        }

        /* Date divider */
        .date-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            color: #9ca3af;
            margin: 6px 0;
        }

        .date-divider::before,
        .date-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        /* Footer */
        .chat-footer {
            padding: 14px 16px;
            border-top: 1px solid #f0f0f0;
            background: #fff;
            flex-shrink: 0;
        }

        .privacy-note {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 12px;
            color: #15803d;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .anon-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
            cursor: pointer;
            width: fit-content;
        }

        .anon-toggle input {
            accent-color: #0f5c42;
        }

        .chat-form {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .chat-input {
            flex: 1;
            padding: 10px 14px;
            font-size: 14px;
            font-family: inherit;
            border: 1px solid #d1d5db;
            border-radius: 24px;
            resize: none;
            outline: none;
            max-height: 120px;
            line-height: 1.5;
            transition: border-color 0.2s;
            background: #fff;
            color: #111827;
        }

        .chat-input:focus {
            border-color: #0f5c42;
        }

        .chat-send {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0f5c42;
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.2s;
        }

        .chat-send:hover {
            background: #0a3d2e;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            color: #9ca3af;
            margin: auto;
            padding: 40px 20px;
        }

        .empty-icon {
            width: 56px;
            height: 56px;
            background: #f0fdf4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            border: 1px solid #bbf7d0;
        }
    </style>
@endsection

@section('content')
    <div class="chat-wrap">

        {{-- Header --}}
        <div class="chat-header">
            <div class="chat-avatar">
                <svg width="18" height="18" viewBox="0 0 22 22" fill="none">
                    <path d="M11 2C11 2 4 7 4 12.5C4 16.09 7.13 19 11 19C14.87 19 18 16.09 18 12.5C18 7 11 2 11 2Z"
                        fill="rgba(255,255,255,0.9)" />
                    <circle cx="11" cy="12.5" r="2.8" fill="#0f5c42" />
                </svg>
            </div>
            <div style="flex:1; min-width:0;">
                <div style="font-size:14px; font-weight:600; color:#111827;">eKalinga Community Space</div>
                <div style="font-size:11px; color:#6b7280;">PLSP Center for Mental Health · Open to all students</div>
            </div>
            <span
                style="background:#f0fdf4; color:#16a34a; font-size:11px; font-weight:600; padding:3px 10px; border-radius:10px; border:1px solid #bbf7d0; flex-shrink:0;">
                <i class="ti ti-users" style="font-size:10px;"></i> {{ $onlineCount }} online
            </span>
        </div>

        {{-- Online members strip --}}
        <div class="members-strip">
            <div class="members-label">
                <span
                    style="display:inline-block; width:7px; height:7px; border-radius:50%; background:#16a34a; margin-right:4px; vertical-align:middle;"></span>
                {{ $onlineCount }} member{{ $onlineCount !== 1 ? 's' : '' }} online
            </div>
            <div class="members-chips">
                @foreach ($onlineMembers as $member)
                    <div class="member-chip">
                        <span class="dot dot-online"></span>
                        @if ($member->is_facilitator)
                            {{ $member->name }}
                            <span class="facilitator-badge" style="font-size:9px; padding:0 4px;">Facilitator</span>
                        @else
                            {{ $member->id === auth()->id() ? 'You' : 'Student' }}
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Messages --}}
        <div class="chat-body" id="chatBody">

            @if ($messages->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="ti ti-message-heart" style="font-size:24px; color:#0f5c42;"></i>
                    </div>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin-bottom:6px;">Welcome to the community!</p>
                    <p style="font-size:13px; color:#6b7280; max-width:280px; margin:0 auto; line-height:1.6;">
                        Be the first to share something. You can always post anonymously.
                    </p>
                </div>
            @endif

            @foreach ($messages as $i => $msg)
                @php
                    $isMine = $msg->sender_id === auth()->id();
                    $showDate = $i === 0 || $msg->created_at->format('Y-m-d') !== $messages[$i - 1]->created_at->format('Y-m-d');
                    $sender = $msg->sender;
                    $isFacil = $sender && $sender->is_facilitator;

                    // Initials for avatar
                    $initials = 'S';
                    if ($sender && !$msg->is_anonymous) {
                        $parts = explode(' ', $sender->name);
                        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                    }

                    // Avatar bg color per user (deterministic)
                    $colors = ['#dbeafe|#1e40af', '#fce7f3|#9d174d', '#fef3c7|#92400e', '#ede9fe|#5b21b6', '#d1fae5|#065f46'];
                    $colorPair = explode('|', $colors[($msg->sender_id ?? 0) % count($colors)]);
                @endphp

                @if ($showDate)
                    <div class="date-divider">{{ $msg->created_at->format('F j, Y') }}</div>
                @endif

                <div class="msg-row {{ $isMine ? 'mine' : '' }}">

                    {{-- Avatar --}}
                    @if ($msg->is_anonymous)
                        <div class="avatar-circle" style="background:#f3f4f6; color:#9ca3af; border:1px solid #e5e7eb;">
                            <i class="ti ti-user-off" style="font-size:13px;"></i>
                        </div>
                    @elseif ($isFacil)
                        <div class="avatar-circle" style="background:#f0fdf4; color:#0f5c42; border:1px solid #bbf7d0;">
                            {{ $initials }}
                        </div>
                    @elseif ($isMine)
                        <div class="avatar-circle" style="background:#0f5c42; color:#fff;">
                            {{ $initials }}
                        </div>
                    @else
                        <div class="avatar-circle"
                            style="background:{{ $colorPair[0] }}; color:{{ $colorPair[1] }}; border:1px solid {{ $colorPair[0] }};">
                            {{ $initials }}
                        </div>
                    @endif

                    <div class="bubble-group">

                        {{-- Sender label --}}
                        <div class="sender-name">
                            @if ($msg->is_anonymous)
                                <span class="anon-badge"><i class="ti ti-user-off" style="font-size:9px;"></i> Anonymous</span>
                            @elseif ($isMine)
                                You
                            @elseif ($isFacil)
                                {{ $sender->name }}
                                <span class="facilitator-badge"><i class="ti ti-shield-check" style="font-size:9px;"></i>
                                    Facilitator</span>
                            @else
                                {{ $sender->name ?? 'Student' }}
                            @endif
                        </div>

                        {{-- Bubble --}}
                        <div class="bubble {{ $isMine ? 'mine' : ($isFacil ? 'facilitator' : 'theirs') }}">
                            {{ $msg->body }}
                        </div>

                        {{-- Meta --}}
                        <div class="bubble-meta">
                            {{ $msg->created_at->format('g:i A') }}
                            @if ($isMine && $msg->read_at)
                                · <span style="color:#0f5c42;">Seen</span>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Input --}}
        <div class="chat-footer">
            <div class="privacy-note">
                <i class="ti ti-shield-check" style="font-size:14px; flex-shrink:0;"></i>
                Messages are visible to all community members. You can post anonymously anytime.
            </div>

            <form method="POST" action="{{ route('community.send') }}" id="chatForm">
                @csrf

                <label class="anon-toggle">
                    <input type="checkbox" name="is_anonymous" value="1">
                    Send this message anonymously
                </label>

                <div class="chat-form">
                    <textarea name="body" class="chat-input" placeholder="Share something with the community..." rows="1"
                        id="chatInput" required></textarea>
                    <button type="submit" class="chat-send" title="Send">
                        <i class="ti ti-send"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const chatBody = document.getElementById('chatBody');
        chatBody.scrollTop = chatBody.scrollHeight;

        const input = document.getElementById('chatInput');
        input.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (this.value.trim()) {
                    document.getElementById('chatForm').submit();
                }
            }
        });
    </script>
@endsection