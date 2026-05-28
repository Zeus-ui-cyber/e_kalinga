<?php
// ═══════════════════════════════════════════════════
//  app/Http/Controllers/Auth/LoginController.php
// ═══════════════════════════════════════════════════

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /** Show the login / register page */
    public function showLogin()
    {
        // Redirect already-authenticated users
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /** Handle login form submission */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Generate 6-digit OTP and cache it for 5 minutes
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            Cache::put("otp_{$user->id}", $otp, now()->addMinutes(5));

            // Store email in session so the 2FA page can display it
            session(['2fa_email' => $user->email, '2fa_user_id' => $user->id]);

            // Log out temporarily — user must verify OTP first
            Auth::logout();

            // Send OTP email
            Mail::to($user->email)->send(new \App\Mail\OtpMail($otp, $user->name));

            return redirect()->route('2fa.form');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}


// ═══════════════════════════════════════════════════
//  app/Http/Controllers/Auth/RegisterController.php
// ═══════════════════════════════════════════════════

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /** Handle student registration */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:users,email'],
            'student_id'      => ['required', 'string', 'unique:users,student_id'],
            'program_section' => ['required', 'string', 'max:100'],
            'password'        => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $user = User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'student_id'      => $validated['student_id'],
            'program_section' => $validated['program_section'],
            'password'        => Hash::make($validated['password']),
            'role'            => 'student', // always student on self-registration
        ]);

        // Send OTP for email verification / 2FA
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put("otp_{$user->id}", $otp, now()->addMinutes(5));

        session(['2fa_email' => $user->email, '2fa_user_id' => $user->id]);

        Mail::to($user->email)->send(new \App\Mail\OtpMail($otp, $user->name));

        return redirect()->route('2fa.form');
    }
}


// ═══════════════════════════════════════════════════
//  app/Http/Controllers/Auth/TwoFactorController.php
// ═══════════════════════════════════════════════════

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    /** Show the OTP entry form */
    public function showForm()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.two-factor');
    }

    /** Verify the OTP */
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

        // OTP is valid — clear it and log the user in
        Cache::forget("otp_{$userId}");
        session()->forget(['2fa_user_id', '2fa_email']);

        $user = User::findOrFail($userId);
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /** Resend the OTP */
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