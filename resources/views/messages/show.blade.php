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

        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: #0284c7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
            margin-right: 4px;
        }

        .back-btn:hover {
            background: #f3f4f6;
            color: #111827;
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
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
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
                box-shadow 0.2s ease;
            box-shadow: 0 2px 8px rgba(15, 92, 66, 0.3);
        }

        .chat-send:hover {
            transform: scale(1.12);
            box-shadow: 0 4px 16px rgba(15, 92, 66, 0.4);
        }

        .chat-send:active {
            transform: scale(0.93);
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            color: #9ca3af;
            margin: auto;
            padding: 32px;
            animation: fadeIn 0.5s ease both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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

        /* ── Anonymous badge ── */
        .anon-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #fef9c3;
            color: #854d0e;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 6px;
            margin-bottom: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="chat-wrap">

        {{-- Header --}}
        <div class="chat-header">
            <a href="{{ route('messages.index') }}" class="back-btn">
                <i class="ti ti-arrow-left" style="font-size:15px;"></i>
                Back
            </a>
            <div class="student-avatar">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:14px; font-weight:600; color:#111827; letter-spacing:-0.01em;">
                    {{ $student->name }}
                </div>
                @if($student->program_section)
                    <div style="font-size:11px; color:#6b7280;">{{ $student->program_section }}</div>
                @else
                    <div style="font-size:11px; color:#6b7280;">Student</div>
                @endif
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
                        <i class="ti ti-message-circle" style="font-size:26px; color:#0f5c42;"></i>
                    </div>
                    <p style="font-size:14px; font-weight:600; color:#111827; margin-bottom:6px;">No messages yet</p>
                    <p style="font-size:13px; color:#6b7280; max-width:280px; margin:0 auto; line-height:1.6;">
                        Start the conversation with {{ $student->name }}.
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

                <div class="bubble-wrap {{ $isMine ? 'mine' : 'theirs' }}">
                    <div>
                        @if (!$isMine && $msg->is_anonymous)
                            <div class="anon-badge">
                                <i class="ti ti-user-off" style="font-size:9px;"></i> Anonymous
                            </div>
                        @endif
                        <div class="bubble {{ $isMine ? 'mine' : 'theirs' }}">{{ $msg->body }}</div>
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
            <form method="POST" action="{{ route('messages.send', $student->id) }}" id="chatForm">
                @csrf
                <div class="chat-form">
                    <textarea name="body" class="chat-input" placeholder="Reply to {{ $student->name }}…" rows="1"
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

        // Stagger bubble animations
        document.querySelectorAll('.bubble-wrap').forEach((el, i) => {
            el.style.animationDelay = Math.min(i * 0.04, 0.4) + 's';
        });
    </script>
@endsection