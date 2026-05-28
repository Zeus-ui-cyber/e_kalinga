@extends('dashboard.layout')

@section('title', $page)
@section('page-title', $page)

@section('content')
    <div
        style="display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:400px; text-align:center;">
        <div
            style="width:72px; height:72px; background:#f0fdf4; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px; border:1px solid #bbf7d0;">
            <i class="ti ti-tools" style="font-size:30px; color:#0f5c42;"></i>
        </div>
        <h2 style="font-size:20px; font-weight:700; color:#111827; margin-bottom:8px;">{{ $page }} is coming soon</h2>
        <p style="font-size:14px; color:#6b7280; max-width:360px; line-height:1.6;">
            This module is currently being built. Check back soon!
        </p>
    </div>
@endsection