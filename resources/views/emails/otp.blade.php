@component('mail::message')

# Hi, {{ $userName }}!

You are signing in to **eKalinga** — PLSP Center for Mental Health Portal.

Your one-time verification code is:

@component('mail::panel')
<div
    style="font-size: 38px; font-weight: 700; letter-spacing: 14px; text-align: center; color: #0f5c42; padding: 8px 0;">
    {{ $otp }}
</div>
@endcomponent

**This code expires in 5 minutes.**

Do not share this code with anyone, including eKalinga staff.

If you did not attempt to sign in or register, please ignore this email — your account remains safe.

---

*eKalinga Digital Mental Health Record System*
*Pamantasan ng Lungsod ng San Pablo*

@endcomponent