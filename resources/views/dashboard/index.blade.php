@extends('dashboard.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    {{-- Greeting --}}
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 4px;">
            Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }},
            {{ explode(' ', auth()->user()->name)[0] }} 👋
        </h1>
        <p style="font-size: 13px; color: #6b7280;">
            {{ now()->format('l, F j, Y') }} ·
            @if (auth()->user()->isAdmin())
                Admin Portal — Full access
            @else
                Student Portal — {{ auth()->user()->program_section ?? 'PLSP' }}
            @endif
        </p>
    </div>

    @if (auth()->user()->isAdmin())

        {{-- ── ADMIN VIEW ── --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Students this semester</span>
                    <div class="stat-card-icon" style="background:#eff6ff;color:#2563eb;">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['total_students'] ?? 0 }}</div>
                <div class="stat-card-sub">Registered in eKalinga</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Active cases</span>
                    <div class="stat-card-icon" style="background:#fef3c7;color:#d97706;">
                        <i class="ti ti-file-alert"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['active_cases'] ?? 0 }}</div>
                <div class="stat-card-sub">Ongoing this week</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Referrals sent</span>
                    <div class="stat-card-icon" style="background:#fdf2f8;color:#9333ea;">
                        <i class="ti ti-transfer"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['referrals'] ?? 0 }}</div>
                <div class="stat-card-sub">To Guidance Office</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Unread messages</span>
                    <div class="stat-card-icon" style="background:#f0fdf4;color:#16a34a;">
                        <i class="ti ti-message-circle"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['unread_messages'] ?? 0 }}</div>
                <div class="stat-card-sub">From students</div>
            </div>
        </div>

        <div class="content-grid">

            {{-- Recent students --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Recent Student Records</span>
                    <a href="{{ route('admin.students.index') }}" class="btn-sm">
                        <i class="ti ti-arrow-right"></i> View all
                    </a>
                </div>
                <div class="card-body" style="padding:0;">
                    <table style="width:100%;border-collapse:collapse;font-size:13px;">
                        <thead>
                            <tr style="background:#f9fafb;border-bottom:1px solid #e5e7eb;">
                                <th style="padding:10px 20px;text-align:left;font-weight:600;color:#6b7280;">Student</th>
                                <th style="padding:10px 20px;text-align:left;font-weight:600;color:#6b7280;">Program</th>
                                <th style="padding:10px 20px;text-align:left;font-weight:600;color:#6b7280;">Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentStudents ?? [] as $student)
                                <tr style="border-bottom:1px solid #f0f0f0;">
                                    <td style="padding:12px 20px;">
                                        <div style="display:flex;align-items:center;gap:8px;">
                                            <div
                                                style="width:28px;height:28px;border-radius:50%;background:#e0f2fe;color:#0284c7;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>
                                            <span style="font-weight:500;color:#111827;">{{ $student->name }}</span>
                                        </div>
                                    </td>
                                    <td style="padding:12px 20px;color:#6b7280;">{{ $student->program_section ?? '—' }}</td>
                                    <td style="padding:12px 20px;color:#6b7280;">{{ $student->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="padding:32px;text-align:center;color:#9ca3af;">
                                        <i class="ti ti-users" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                        No students registered yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right column --}}
            <div style="display:flex;flex-direction:column;gap:16px;">

                <div class="card">
                    <div class="card-header"><span class="card-title">Quick actions</span></div>
                    <div class="card-body" style="display:flex;flex-direction:column;gap:8px;">
                        <a href="{{ route('admin.students.index') }}" class="btn-sm btn-primary"
                            style="justify-content:center;">
                            <i class="ti ti-users"></i> Student Records
                        </a>
                        <a href="{{ route('feed.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-news"></i> Org Feed
                        </a>
                        <a href="{{ route('messages.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-message-circle"></i> Messages
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-chart-bar"></i> Reports
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><span class="card-title">Top concerns this month</span></div>
                    <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                        @foreach ($trends ?? [['label' => 'Academic stress', 'pct' => 45], ['label' => 'Family issues', 'pct' => 28], ['label' => 'Mental health', 'pct' => 19], ['label' => 'Other', 'pct' => 8]] as $trend)
                            <div>
                                <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:4px;">
                                    <span style="color:#374151;font-weight:500;">{{ $trend['label'] }}</span>
                                    <span style="color:#6b7280;">{{ $trend['pct'] }}%</span>
                                </div>
                                <div style="height:6px;background:#f0f0f0;border-radius:4px;overflow:hidden;">
                                    <div
                                        style="height:100%;width:{{ $trend['pct'] }}%;background:linear-gradient(90deg,#0f5c42,#1a7a58);border-radius:4px;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    @else

        {{-- ── STUDENT VIEW ── --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Sessions attended</span>
                    <div class="stat-card-icon" style="background:#f0fdf4;color:#16a34a;">
                        <i class="ti ti-file-text"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['sessions'] ?? 0 }}</div>
                <div class="stat-card-sub">Total this semester</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Messages sent</span>
                    <div class="stat-card-icon" style="background:#eff6ff;color:#2563eb;">
                        <i class="ti ti-message-circle"></i>
                    </div>
                </div>
                <div class="stat-card-value">{{ $stats['messages_sent'] ?? 0 }}</div>
                <div class="stat-card-sub">To your facilitator</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">Next appointment</span>
                    <div class="stat-card-icon" style="background:#fef3c7;color:#d97706;">
                        <i class="ti ti-calendar"></i>
                    </div>
                </div>
                <div class="stat-card-value" style="font-size:16px;padding-top:4px;">None</div>
                <div class="stat-card-sub">No upcoming appointments</div>
            </div>
        </div>

        <div class="content-grid">

            <div class="card">
                <div class="card-header">
                    <span class="card-title">Latest from the Org</span>
                    <a href="{{ route('feed.index') }}" class="btn-sm"><i class="ti ti-arrow-right"></i> See all</a>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">
                    @forelse ($feedPosts ?? [] as $post)
                        <div style="border-bottom:1px solid #f0f0f0;padding-bottom:16px;">
                            <p style="font-size:13px;font-weight:600;color:#111827;margin-bottom:4px;">{{ $post->title }}</p>
                            <p style="font-size:12px;color:#6b7280;line-height:1.5;">{{ Str::limit($post->body, 100) }}</p>
                            <p style="font-size:11px;color:#9ca3af;margin-top:6px;">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <div style="text-align:center;color:#9ca3af;padding:24px 0;font-size:13px;">
                            <i class="ti ti-news" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                            No posts yet. Check back soon!
                        </div>
                    @endforelse
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:16px;">

                <div class="card">
                    <div class="card-header"><span class="card-title">Quick actions</span></div>
                    <div class="card-body" style="display:flex;flex-direction:column;gap:8px;">
                        <a href="{{ route('messages.index') }}" class="btn-sm btn-primary" style="justify-content:center;">
                            <i class="ti ti-message-circle"></i> Message your facilitator
                        </a>
                        <a href="{{ route('student.sessions') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-file-text"></i> View session history
                        </a>
                        <a href="{{ route('student.profile') }}" class="btn-sm" style="justify-content:center;">
                            <i class="ti ti-user-circle"></i> Update my profile
                        </a>
                    </div>
                </div>

                <div class="card" style="border-color:#bbf7d0;">
                    <div class="card-body" style="display:flex;gap:12px;align-items:flex-start;">
                        <div
                            style="width:32px;height:32px;background:#f0fdf4;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="ti ti-shield-check" style="color:#16a34a;font-size:17px;"></i>
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:600;color:#111827;margin-bottom:4px;">Your privacy is protected
                            </p>
                            <p style="font-size:12px;color:#6b7280;line-height:1.5;">Your records and conversations are
                                encrypted and only visible to authorized facilitators.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    @endif

@endsection