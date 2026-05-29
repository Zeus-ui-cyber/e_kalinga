<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
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
            'role'            => 'student',
        ]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put("otp_{$user->id}", $otp, now()->addMinutes(5));
        session(['2fa_email' => $user->email, '2fa_user_id' => $user->id]);

        Mail::to($user->email)->send(new \App\Mail\OtpMail($otp, $user->name));

        return redirect()->route('2fa.form');
    }
}