@extends('dashboard.layout')

@section('title', 'Messages')
@section('page-title', 'Messages')

@section('content')
    <div style="max-width: 760px;">

        {{-- Admin inbox: list of student threads --}}
        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden;">

            <div
                style="padding:16px 20px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-size:15px; font-weight:600; color:#111827;">Inbox</span>
                <span style="font-size:12px; color:#6b7280;">{{ $threads->count() }}
                    student{{ $threads->count() !== 1 ? 's' : '' }}</span>
            </div>

            @forelse ($threads as $thread)
                @php $student = $thread['student'];
                    $last = $thread['lastMessage'];
                $unread = $thread['unread']; @endphp
                <a href="{{ route('messages.show', $student->id) }}"
                    style="display:flex; align-items:center; gap:14px; padding:14px 20px; border-bottom:1px solid #f9f9f9; text-decoration:none; transition:background 0.15s; {{ $unread > 0 ? 'background:#f0fdf4;' : '' }}"
                    onmouseover="this.style.background='#f9fafb'"
                    onmouseout="this.style.background='{{ $unread > 0 ? '#f0fdf4' : '' }}'">

                    {{-- Avatar --}}
                    <div
                        style="width:42px; height:42px; border-radius:50%; background:#e0f2fe; color:#0284c7; display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:700; flex-shrink:0;">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>

                    {{-- Info --}}
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2px;">
                            <span style="font-size:14px; font-weight:{{ $unread > 0 ? '700' : '500' }}; color:#111827;">
                                {{ $last && $last->is_anonymous ? 'Anonymous Student' : $student->name }}
                            </span>
                            <span style="font-size:11px; color:#9ca3af;">
                                {{ $last ? $last->created_at->diffForHumans() : '' }}
                            </span>
                        </div>
                        <div
                            style="font-size:13px; color:#6b7280; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:480px;">
                            @if ($last)
                                {{ $last->sender_id === auth()->id() ? 'You: ' : '' }}{{ Str::limit($last->body, 80) }}
                            @else
                                <span style="color:#9ca3af; font-style:italic;">No messages yet — start the conversation</span>
                            @endif
                        </div>
                        @if ($student->program_section)
                            <div style="font-size:11px; color:#9ca3af; margin-top:2px;">{{ $student->program_section }}</div>
                        @endif
                    </div>

                    {{-- Unread badge --}}
                    @if ($unread > 0)
                        <div
                            style="background:#0f5c42; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:10px; flex-shrink:0;">
                            {{ $unread }}
                        </div>
                    @else
                        <i class="ti ti-chevron-right" style="color:#d1d5db; font-size:16px;"></i>
                    @endif

                </a>
            @empty
                <div style="padding:48px; text-align:center; color:#9ca3af;">
                    <i class="ti ti-message-circle" style="font-size:32px; display:block; margin-bottom:12px;"></i>
                    <p style="font-size:14px;">No students registered yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection