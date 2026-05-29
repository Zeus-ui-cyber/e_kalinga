<aside class="sidebar-right">

    {{-- UPCOMING EVENTS --}}
    <div class="widget-card">

        <div class="widget-title">
            <i class="ti ti-calendar-event"></i> Upcoming events
        </div>

        @forelse($upcomingEvents ?? [] as $event)

            <div class="upcoming-item">

                <div class="upcoming-date-box">
                    <div class="upcoming-month">
                        {{ \Carbon\Carbon::parse($event->date)->format('M') }}
                    </div>
                    <div class="upcoming-day">
                        {{ \Carbon\Carbon::parse($event->date)->format('d') }}
                    </div>
                </div>

                <div class="upcoming-info">
                    <div class="upcoming-name">{{ $event->title }}</div>
                    <div class="upcoming-time">
                        {{ $event->time }} · {{ $event->location }}
                    </div>
                </div>

            </div>

        @empty

            <p style="font-size:12px;color:var(--text-tertiary);">
                No upcoming events
            </p>

        @endforelse

    </div>

    {{-- ACTIVE MEMBERS --}}
    <div class="widget-card">

        <div class="widget-title">
            <i class="ti ti-users"></i> Active members
        </div>

        @forelse($activeMembers ?? [] as $member)

            <div class="member-item">

                <div class="member-av" style="background: {{ $member->bg ?? '#E6F1FB' }};
                        color: {{ $member->color ?? '#185FA5' }};">
                    {{ $member->initials }}
                </div>

                <div>
                    <div class="member-name">{{ $member->name }}</div>
                    <div class="member-role">{{ $member->role }}</div>
                </div>

                @if($member->online ?? false)
                    <div class="online-dot"></div>
                @endif

            </div>

        @empty

            <p style="font-size:12px;color:var(--text-tertiary);">
                No active members
            </p>

        @endforelse

    </div>

    {{-- QUICK INFO WIDGET --}}
    <div class="widget-card">

        <div class="widget-title">
            <i class="ti ti-info-circle"></i> Organization Info
        </div>

        <p style="font-size:12px;color:var(--text-secondary);line-height:1.5;">
            Welcome to the Computer Society portal.
            Stay updated with announcements, events, and community activities.
        </p>

    </div>

</aside>