@extends('dashboard.layout')

@section('title', 'Chat with ' . $student->name)
@section('page-title', 'Chat with ' . $student->name)

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
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e0f2fe;
            color: #0284c7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
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

        .date-divider {
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            margin: 8px 0;
        }
    </style>
@endsection

@section('content')
    <div class="chat-wrap">

        {{-- Header --}}
        <div class="chat-header">
            <a href="{{ route('messages.index') }}"
                style="color:#6b7280; text-decoration:none; font-size:18px; margin-right:4px;">
                <i class="ti ti-arrow-left"></i>
            </a>
            <div class="chat-avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
            <div>
                <div style="font-size:14px; font-weight:600; color:#111827;">{{ $student->name }}</div>
                <div style="font-size:11px; color:#6b7280;">{{ $student->program_section ?? 'Student' }}</div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="chat-body" id="chatBody">
            @forelse ($messages as $i => $msg)
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
                            {{ $msg->created_at->format('g:i A') }}
                            @if ($isMine && $msg->read_at)
                                · <span style="color:#0f5c42;">Seen</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align:center; color:#9ca3af; margin:auto; padding:32px;">
                    <i class="ti ti-message-circle" style="font-size:32px; display:block; margin-bottom:10px;"></i>
                    <p style="font-size:14px;">No messages yet. Say hello!</p>
                </div>
            @endforelse
        </div>

        {{-- Input --}}
        <div class="chat-footer">
            <form method="POST" action="{{ route('messages.send', $student->id) }}" id="chatForm">
                @csrf
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
        // Auto-scroll to bottom
        const chatBody = document.getElementById('chatBody');
        chatBody.scrollTop = chatBody.scrollHeight;

        // Auto-resize textarea
        const input = document.getElementById('chatInput');
        input.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // Send on Enter (Shift+Enter for newline)
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