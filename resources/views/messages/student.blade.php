@extends('dashboard.layout')

@section('title', 'Messages')
@section('page-title', 'Messages')

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
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #f9fafb;
        }

        .bubble-wrap {
            display: flex;
        }

        .bubble-wrap.mine {
            justify-content: flex-end;
        }

        .bubble-wrap.theirs {
            justify-content: flex-start;
        }

        .bubble {
            max-width: 70%;
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

        .bubble-meta {
            font-size: 11px;
            margin-top: 4px;
            color: #9ca3af;
        }

        .bubble-wrap.mine .bubble-meta {
            text-align: right;
        }

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

        .anon-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .anon-toggle input {
            accent-color: #0f5c42;
        }

        .date-divider {
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            margin: 8px 0;
        }

        .privacy-note {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            color: #15803d;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
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
                <div style="font-size:14px; font-weight:600; color:#111827;">eKalinga Support</div>
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

            {{-- Welcome message if no messages --}}
            @if ($messages->isEmpty())
                <div style="text-align:center; color:#9ca3af; margin:auto; padding:32px;">
                    <div
                        style="width:56px; height:56px; background:#f0fdf4; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; border:1px solid #bbf7d0;">
                        <i class="ti ti-message-heart" style="font-size:24px; color:#0f5c42;"></i>
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

                <div class="bubble-wrap {{ $isMine ? 'mine' : 'theirs' }}">
                    <div>
                        <div class="bubble {{ $isMine ? 'mine' : 'theirs' }}">
                            {{ $msg->body }}
                        </div>
                        <div class="bubble-meta">
                            @if ($isMine && $msg->is_anonymous)
                                <span style="color:#9ca3af;"><i class="ti ti-user-off" style="font-size:10px;"></i> Sent anonymously
                                    · </span>
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

                    {{-- Anonymous toggle --}}
                    <label class="anon-toggle">
                        <input type="checkbox" name="is_anonymous" value="1">
                        Send this message anonymously
                    </label>

                    <div class="chat-form">
                        <textarea name="body" class="chat-input" placeholder="Type your message..." rows="1" id="chatInput"
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