@extends('dashboard.layout')

@section('title', 'Account Settings')
@section('page-title', 'Account Settings')

@section('content')
    <div style="max-width: 760px;">

        @if (session('success'))
            <div
                style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:12px 16px;font-size:13px;color:#15803d;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                <i class="ti ti-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Profile picture --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <span class="card-title"><i class="ti ti-photo" style="margin-right:6px;"></i> Profile Photo</span>
                </div>
                <div class="card-body" style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
                    <div style="position:relative;flex-shrink:0;">
                        @if ($user->profile_picture)
                            <img src="{{ Storage::url($user->profile_picture) }}" id="avatarPreview"
                                style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #e5e7eb;">
                        @else
                            <div id="avatarPreview"
                                style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#0f5c42,#1a7a58);display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:700;color:#fff;border:3px solid #e5e7eb;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <label for="profile_picture"
                            style="position:absolute;bottom:0;right:0;width:28px;height:28px;background:#0f5c42;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;border:2px solid #fff;">
                            <i class="ti ti-camera" style="font-size:13px;color:#fff;"></i>
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                            style="display:none;" onchange="previewImage(this)">
                    </div>
                    <div>
                        <p style="font-size:13px;color:#374151;font-weight:500;margin-bottom:4px;">{{ $user->name }}</p>
                        <p style="font-size:12px;color:#9ca3af;">Click the camera icon to upload a new photo.</p>
                        <p style="font-size:11px;color:#9ca3af;margin-top:2px;">JPG, PNG or GIF · Max 2MB</p>
                    </div>
                </div>
            </div>

            {{-- Personal info --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <span class="card-title"><i class="ti ti-user" style="margin-right:6px;"></i> Personal
                        Information</span>
                </div>
                <div class="card-body">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

                        <div>
                            <label
                                style="display:block;font-size:12px;font-weight:500;color:#4b5563;margin-bottom:5px;">Full
                                Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                style="width:100%;padding:9px 12px;font-size:14px;font-family:inherit;border:1px solid #d1d5db;border-radius:8px;background:#f9fafb;color:#111827;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0f5c42'" onblur="this.style.borderColor='#d1d5db'"
                                required>
                            @error('name') <p style="font-size:11px;color:#ef4444;margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12px;font-weight:500;color:#4b5563;margin-bottom:5px;">Phone
                                Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                placeholder="e.g. 09xxxxxxxxx"
                                style="width:100%;padding:9px 12px;font-size:14px;font-family:inherit;border:1px solid #d1d5db;border-radius:8px;background:#f9fafb;color:#111827;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0f5c42'" onblur="this.style.borderColor='#d1d5db'">
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12px;font-weight:500;color:#4b5563;margin-bottom:5px;">Student
                                ID</label>
                            <input type="text" value="{{ $user->student_id ?? 'Not set' }}"
                                style="width:100%;padding:9px 12px;font-size:14px;font-family:inherit;border:1px solid #e5e7eb;border-radius:8px;background:#f3f4f6;color:#9ca3af;outline:none;box-sizing:border-box;"
                                disabled>
                            <p style="font-size:11px;color:#9ca3af;margin-top:3px;">Student ID cannot be changed.</p>
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12px;font-weight:500;color:#4b5563;margin-bottom:5px;">Program
                                & Section</label>
                            <input type="text" name="program_section"
                                value="{{ old('program_section', $user->program_section) }}" placeholder="e.g. BSIT - 3A"
                                style="width:100%;padding:9px 12px;font-size:14px;font-family:inherit;border:1px solid #d1d5db;border-radius:8px;background:#f9fafb;color:#111827;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0f5c42'" onblur="this.style.borderColor='#d1d5db'">
                        </div>

                    </div>
                </div>
            </div>

            {{-- Change password --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <span class="card-title"><i class="ti ti-lock" style="margin-right:6px;"></i> Change Password</span>
                    <span style="font-size:12px;color:#9ca3af;">Leave blank to keep current password</span>
                </div>
                <div class="card-body">
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">

                        <div>
                            <label
                                style="display:block;font-size:12px;font-weight:500;color:#4b5563;margin-bottom:5px;">Current
                                Password</label>
                            <input type="password" name="current_password" placeholder="••••••••"
                                style="width:100%;padding:9px 12px;font-size:14px;font-family:inherit;border:1px solid {{ $errors->has('current_password') ? '#ef4444' : '#d1d5db' }};border-radius:8px;background:#f9fafb;color:#111827;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0f5c42'" onblur="this.style.borderColor='#d1d5db'">
                            @error('current_password') <p style="font-size:11px;color:#ef4444;margin-top:4px;">
                            {{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label style="display:block;font-size:12px;font-weight:500;color:#4b5563;margin-bottom:5px;">New
                                Password</label>
                            <input type="password" name="new_password" placeholder="Min. 8 characters"
                                style="width:100%;padding:9px 12px;font-size:14px;font-family:inherit;border:1px solid #d1d5db;border-radius:8px;background:#f9fafb;color:#111827;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0f5c42'" onblur="this.style.borderColor='#d1d5db'">
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12px;font-weight:500;color:#4b5563;margin-bottom:5px;">Confirm
                                New Password</label>
                            <input type="password" name="new_password_confirmation" placeholder="••••••••"
                                style="width:100%;padding:9px 12px;font-size:14px;font-family:inherit;border:1px solid #d1d5db;border-radius:8px;background:#f9fafb;color:#111827;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0f5c42'" onblur="this.style.borderColor='#d1d5db'">
                        </div>

                    </div>
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;">
                <button type="submit"
                    style="padding:11px 28px;font-size:14px;font-family:inherit;font-weight:600;border-radius:8px;border:none;background:#0f5c42;color:#fff;cursor:pointer;display:flex;align-items:center;gap:8px;"
                    onmouseover="this.style.background='#0a3d2e'" onmouseout="this.style.background='#0f5c42'">
                    <i class="ti ti-device-floppy"></i> Save Changes
                </button>
            </div>

        </form>
    </div>

    @section('scripts')
        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.getElementById('avatarPreview');
                        if (preview.tagName === 'DIV') {
                            const img = document.createElement('img');
                            img.id = 'avatarPreview';
                            img.style.cssText = 'width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #e5e7eb;';
                            img.src = e.target.result;
                            preview.parentNode.replaceChild(img, preview);
                        } else {
                            preview.src = e.target.result;
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endsection

@endsection