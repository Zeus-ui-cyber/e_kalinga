<?php
// ═══════════════════════════════════════════════════
//  app/Mail/OtpMail.php
// ═══════════════════════════════════════════════════

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $userName
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your eKalinga Verification Code',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.otp',
            with: [
                'otp'      => $this->otp,
                'userName' => $this->userName,
            ],
        );
    }
}


/*
─────────────────────────────────────────────────
  resources/views/emails/otp.blade.php
  (Laravel Markdown Mail template)
─────────────────────────────────────────────────
  Save the block below as a SEPARATE file:
  resources/views/emails/otp.blade.php

  Content:

@component('mail::message')

# Hi, {{ $userName }}!

Your **eKalinga** verification code is:

@component('mail::panel')
<div style="font-size: 36px; font-weight: 700; letter-spacing: 12px; text-align: center; color: #0f5c42;">
{{ $otp }}
</div>
@endcomponent

This code expires in **5 minutes**. Do not share it with anyone.

If you did not attempt to sign in to eKalinga, please ignore this email.

---

*PLSP Center for Mental Health*
*eKalinga Digital Mental Health Record System*

@endcomponent

─────────────────────────────────────────────────
*/