@extends('dashboard.layout')

@section('title', 'Messages')
@section('page-title', 'Messages')

@section('head')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap');

        .chat-wrap {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 120px);
            max-width: 760px;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(15, 92, 66, 0.07);
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Header ── */
        .chat-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            background: #fff;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0f5c42, #1a7a58);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
        }

        .chat-avatar::after {
            content: '';
            position: absolute;
            bottom: 1px;
            right: 1px;
            width: 9px;
            height: 9px;
            background: #22c55e;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* ── Body ── */
        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            background: #f9fafb;
            scroll-behavior: smooth;
        }

        .chat-body::-webkit-scrollbar {
            width: 4px;
        }

        .chat-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        /* ── Bubbles ── */
        .bubble-wrap {
            display: flex;
            animation: bubbleIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes bubbleIn {
            from {
                opacity: 0;
                transform: scale(0.85) translateY(8px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .bubble-wrap.mine {
            justify-content: flex-end;
        }

        .bubble-wrap.theirs {
            justify-content: flex-start;
        }

        .bubble {
            padding: 10px 14px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.55;
            word-break: normal;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            width: fit-content;
            max-width: 70%;
            min-width: 48px;
            transition: transform 0.15s ease;
        }

        .bubble:hover {
            transform: scale(1.02);
        }

        .bubble.mine {
            background: linear-gradient(135deg, #0f5c42, #1a7a58);
            color: #fff;
            border-bottom-right-radius: 4px;
            box-shadow: 0 2px 12px rgba(15, 92, 66, 0.25);
        }

        .bubble.theirs {
            background: #fff;
            color: #111827;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .bubble-meta {
            font-size: 11px;
            margin-top: 3px;
            color: #9ca3af;
        }

        .bubble-wrap.mine .bubble-meta {
            text-align: right;
        }

        /* ── Date divider ── */
        .date-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            color: #9ca3af;
            margin: 10px 0;
        }

        .date-divider::before,
        .date-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        /* ── Footer ── */
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
            padding: 9px 13px;
            font-size: 12px;
            color: #15803d;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 11px;
            animation: fadeIn 0.5s ease 0.3s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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
            padding: 10px 16px;
            font-size: 14px;
            font-family: 'DM Sans', inherit;
            border: 1.5px solid #e5e7eb;
            border-radius: 24px;
            resize: none;
            outline: none;
            max-height: 120px;
            line-height: 1.5;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f9fafb;
        }

        .chat-input:focus {
            border-color: #0f5c42;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(15, 92, 66, 0.08);
        }

        .chat-send {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0f5c42, #1a7a58);
            border: none;
            color: #fff;
            font-size: 17px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.2s ease,
                background 0.2s ease;
            box-shadow: 0 2px 8px rgba(15, 92, 66, 0.3);
        }

        .chat-send:hover {
            transform: scale(1.12);
            box-shadow: 0 4px 16px rgba(15, 92, 66, 0.4);
        }

        .chat-send:active {
            transform: scale(0.93);
        }

        /* ── Typing indicator ── */
        .typing-indicator {
            display: flex;
            gap: 4px;
            align-items: center;
            padding: 10px 14px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            border-bottom-left-radius: 4px;
            width: fit-content;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .typing-dot {
            width: 7px;
            height: 7px;
            background: #9ca3af;
            border-radius: 50%;
            animation: typingBounce 1.2s ease-in-out infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typingBounce {

            0%,
            60%,
            100% {
                transform: translateY(0);
                opacity: 0.4;
            }

            30% {
                transform: translateY(-5px);
                opacity: 1;
            }
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            color: #9ca3af;
            margin: auto;
            padding: 32px;
            animation: fadeIn 0.6s ease both;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            border: 1px solid #bbf7d0;
            animation: pulseGlow 2.5s ease-in-out infinite;
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(15, 92, 66, 0.15);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(15, 92, 66, 0);
            }
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
            <div>
                <div style="font-size:14px; font-weight:600; color:#111827; letter-spacing:-0.01em;">eKalinga Support</div>
                <div style="font-size:11px; color:#6b7280;">PLSP Center for Mental Health · Peer Facilitators</div>
            </div>
            <div style="margin-left:auto;">
                <span
                    style="background:#f0fdf4; color:#16a34a; font-size:11px; font-weight:600; padding:3px 10px; border-radius:10px; border:1px solid #bbf7d0;">
                    <i class="ti ti-lock" style="font-size:10px;"></i> Private
                </span>
            </div>
        </div>

        {{-- Messages --}}
        <div class="chat-body" id="chatBody">

            @if ($messages->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="ti ti-message-heart" style="font-size:26px; color:#0f5c42;"></i>
                    </div>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin-bottom:6px;">You're in a safe space</p>
                    <p style="font-size:13px; color:#6b7280; max-width:280px; margin:0 auto; line-height:1.6;">
                        Feel free to reach out to your peer facilitator. You can choose to stay anonymous.
                    </p>
                </div>
            @endif

            @foreach ($messages as $i => $msg)
                @php
                    $isMine = $msg->sender_id === auth()->id();
                    $showDate = $i === 0 || $msg->created_at->format('Y-m-d') !== $messages[$i - 1]->created_at->format('Y-m-d');
                @endphp

                @if ($showDate)
                    <div class="date-divider">{{ $msg->created_at->format('F j, Y') }}</div>
                @endif

                <div class="bubble-wrap {{ $isMine ? 'mine' : 'theirs' }}" style="animation-delay: {{ min($i * 0.04, 0.4) }}s;">
                    <div>
                        <div class="bubble {{ $isMine ? 'mine' : 'theirs' }}">{{ $msg->body }}</div>
                        <div class="bubble-meta">
                            @if ($isMine && $msg->is_anonymous)
                                <span><i class="ti ti-user-off" style="font-size:10px;"></i> Anonymous · </span>
                            @endif
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
                Your conversation is private and only visible to your peer facilitator.
            </div>

            @if($admin)
                <form method="POST" action="{{ route('messages.send', $admin->id) }}" id="chatForm">
            @else
                    <form method="POST" action="#" id="chatForm">
                @endif
                    @csrf

                    <label class="anon-toggle">
                        <input type="checkbox" name="is_anonymous" value="1">
                        Send this message anonymously
                    </label>

                    <div class="chat-form">
                        <textarea name="body" class="chat-input" placeholder="Type your message…" rows="1" id="chatInput"
                            required></textarea>
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
        // Scroll to bottom
        const chatBody = document.getElementById('chatBody');
        chatBody.scrollTop = chatBody.scrollHeight;

        // Auto-resize textarea
        const input = document.getElementById('chatInput');
        input.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // Enter to send
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (this.value.trim()) {
                    document.getElementById('chatForm').submit();
                }
            }
        });

        // Animate new bubbles on stagger
        document.querySelectorAll('.bubble-wrap').forEach((el, i) => {
            el.style.animationDelay = Math.min(i * 0.04, 0.4) + 's';
        });
    </script>
@endsection