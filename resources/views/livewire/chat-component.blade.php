<div class="chat-wrapper">
    {{-- ── MESSAGE DISPLAY AREA ── --}}
    <div class="chat-messages" id="chatMessages" wire:poll.3s>
        @forelse($messages as $msg)
            {{-- Message Row --}}
            <div class="message-row {{ $msg->sender_id === auth()->id() ? 'outgoing' : 'incoming' }}">

                {{-- Admin Avatar (Only on incoming) --}}
                @if($msg->sender_id !== auth()->id())
                    <div class="msg-avatar">
                        <i class="ti ti-shield"></i>
                    </div>
                @endif

                {{-- Bubble & Timestamp --}}
                <div class="msg-container">
                    <div class="msg-bubble">
                        {{ $msg->body }}
                    </div>
                    <div class="msg-time">
                        {{ $msg->created_at->format('h:i A') }}
                        @if($msg->sender_id === auth()->id())
                            <i class="ti ti-checks" style="color: #60a5fa; margin-left: 4px;"></i>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="ti ti-message-dots" style="font-size: 48px; color: #d1d5db; margin-bottom: 16px;"></i>
                <p>No messages yet. Start your conversation with the admin!</p>
            </div>
        @endforelse

        {{-- Loading indicator while sending --}}
        <div wire:loading wire:target="sendMessage" class="message-row incoming">
            <div class="msg-avatar"><i class="ti ti-shield"></i></div>
            <div class="msg-bubble" style="background: #f3f4f6; color: #6b7280; font-size: 12px;">Admin is processing...
            </div>
        </div>
    </div>

    {{-- ── INPUT AREA ── --}}
    <div class="chat-input-area">
        <form wire:submit.prevent="sendMessage">
            <div class="chat-input-wrapper">
                <button type="button" class="btn-icon"><i class="ti ti-paperclip"></i></button>

                <input type="text" wire:model="message" placeholder="Type your concern here..." required
                    autocomplete="off">

                <button type="submit" class="btn-send" wire:loading.attr="disabled">
                    <i class="ti ti-send" wire:loading.remove></i>
                    <i class="ti ti-loader animate-spin" wire:loading></i>
                </button>
            </div>
        </form>
    </div>

    {{-- ── STYLES ── --}}
    <style>
        .chat-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chat-messages {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: #fafafa;
        }

        .empty-state {
            text-align: center;
            color: #9ca3af;
            margin-top: 60px;
            font-size: 14px;
        }

        .message-row {
            display: flex;
            gap: 12px;
            max-width: 75%;
        }

        .incoming {
            align-self: flex-start;
        }

        .outgoing {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .msg-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
        }

        .msg-bubble {
            padding: 12px 18px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.5;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .incoming .msg-bubble {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 4px;
        }

        .outgoing .msg-bubble {
            background: var(--green);
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .msg-time {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 4px;
            display: flex;
            align-items: center;
        }

        .outgoing .msg-time {
            justify-content: flex-end;
        }

        .chat-input-area {
            padding: 20px 30px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
        }

        .chat-input-wrapper {
            display: flex;
            align-items: center;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 30px;
            padding: 8px 20px;
            gap: 12px;
        }

        .chat-input-wrapper input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            padding: 10px 0;
            font-size: 14px;
        }

        .btn-icon {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            font-size: 20px;
        }

        .btn-send {
            background: var(--green);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    {{-- ── AUTO-SCROLL SCRIPT ── --}}
    <script>
        // Use a MutationObserver to scroll to bottom when new messages arrive
        const chatBox = document.getElementById('chatMessages');
        const observer = new MutationObserver(() => {
            chatBox.scrollTop = chatBox.scrollHeight;
        });
        observer.observe(chatBox, { childList: true });

        // Initial scroll
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</div>