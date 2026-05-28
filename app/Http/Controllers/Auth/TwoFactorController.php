<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    public function showForm()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = session('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $cachedOtp = Cache::get("otp_{$userId}");

        if (!$cachedOtp || $cachedOtp !== $request->otp) {
            return back()->withErrors([
                'otp' => 'The code is incorrect or has expired. Please try again.',
            ]);
        }

        Cache::forget("otp_{$userId}");
        session()->forget(['2fa_user_id', '2fa_email']);

        $user = User::findOrFail($userId);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function resend(Request $request)
    {
        $userId = session('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($userId);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put("otp_{$userId}", $otp, now()->addMinutes(5));

        Mail::to($user->email)->send(new \App\Mail\OtpMail($otp, $user->name));

        return back()->with('status', 'A new code has been sent to your email.');
    }
}