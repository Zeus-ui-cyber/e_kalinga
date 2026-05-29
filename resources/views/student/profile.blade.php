@extends('dashboard.layout')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
    <div style="max-width: 700px;">

        {{-- Profile card --}}
        <div class="card" style="margin-bottom:16px;">
            <div class="card-body" style="display:flex;align-items:center;gap:28px;flex-wrap:wrap;padding:32px;">

                {{-- Avatar --}}
                @if ($user->profile_picture)
                    <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile Photo"
                        style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:4px solid #e5e7eb;flex-shrink:0;">
                @else
                    <div
                        style="width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,#0f5c42,#1a7a58);display:flex;align-items:center;justify-content:center;font-size:36px;font-weight:700;color:#fff;border:4px solid #e5e7eb;flex-shrink:0;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                {{-- Name & basic info --}}
                <div style="flex:1;">
                    <div style="font-size:22px;font-weight:700;color:#111827;">{{ $user->name }}</div>
                    <div style="font-size:14px;color:#6b7280;margin-top:4px;">
                        {{ $user->program_section ?? 'No program set' }}</div>
                    <div style="font-size:13px;color:#9ca3af;margin-top:2px;">Student ID:
                        {{ $user->student_id ?? 'Not set' }}</div>
                    <div style="margin-top:14px;">
                        <a href="{{ route('profile.edit') }}"
                            style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#0f5c42;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                            <i class="ti ti-settings"></i> Go to Account Settings
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- Account information --}}
        <div class="card" style="margin-bottom:16px;">
            <div class="card-header">
                <span class="card-title"><i class="ti ti-info-circle" style="margin-right:6px;"></i> Account
                    Information</span>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:0;">

                <div
                    style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid #f0f0f0;">
                    <span style="font-size:13px;color:#6b7280;">Full name</span>
                    <span style="font-size:13px;font-weight:500;color:#111827;">{{ $user->name }}</span>
                </div>

                <div
                    style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid #f0f0f0;">
                    <span style="font-size:13px;color:#6b7280;">Email address</span>
                    <span style="font-size:13px;font-weight:500;color:#111827;">{{ $user->email }}</span>
                </div>

                <div
                    style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid #f0f0f0;">
                    <span style="font-size:13px;color:#6b7280;">Student ID</span>
                    <span style="font-size:13px;font-weight:500;color:#111827;">{{ $user->student_id ?? '—' }}</span>
                </div>

                <div
                    style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid #f0f0f0;">
                    <span style="font-size:13px;color:#6b7280;">Program & Section</span>
                    <span style="font-size:13px;font-weight:500;color:#111827;">{{ $user->program_section ?? '—' }}</span>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;">
                    <span style="font-size:13px;color:#6b7280;">Phone number</span>
                    <span style="font-size:13px;font-weight:500;color:#111827;">{{ $user->phone ?? '—' }}</span>
                </div>

            </div>
        </div>

        {{-- Privacy note --}}
        <div
            style="padding:14px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;display:flex;align-items:center;gap:10px;">
            <i class="ti ti-shield-check" style="font-size:18px;color:#16a34a;flex-shrink:0;"></i>
            <p style="font-size:12px;color:#15803d;line-height:1.6;margin:0;">Your profile information is private and only
                visible to you and authorized facilitators.</p>
        </div>

    </div>
@endsection