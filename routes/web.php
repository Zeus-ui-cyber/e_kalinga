<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommunityController;

// ── Guest-only routes ──
Route::middleware('guest')->group(function () {
    Route::get('/',       [LoginController::class, 'showLogin']);
    Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/verify',         [TwoFactorController::class, 'showForm'])->name('2fa.form');
    Route::post('/verify',        [TwoFactorController::class, 'verify'])->name('2fa.verify');
    Route::post('/verify/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');
});

// ── Authenticated routes ──
Route::middleware('auth')->group(function () {
    Route::post('/logout',   [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',   [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Org Feed (view for all)
    Route::get('/feed',        [\App\Http\Controllers\FeedController::class, 'index'])->name('feed.index');
    Route::get('/feed/{post}', [\App\Http\Controllers\FeedController::class, 'show'])->name('feed.show');

    // Messages (1-on-1)
    Route::get('/messages',            [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}',       [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{id}/send', [MessageController::class, 'send'])->name('messages.send');

    // Community Space
    Route::get('/community',       [CommunityController::class, 'index'])->name('community.index');
    Route::post('/community/send', [CommunityController::class, 'send'])->name('community.send');

    // ── Admin-only ──
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');
        Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);
        
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('/feed/create',      [\App\Http\Controllers\FeedController::class, 'create'])->name('feed.create');
        Route::post('/feed',            [\App\Http\Controllers\FeedController::class, 'store'])->name('feed.store');
        Route::get('/feed/{post}/edit', [\App\Http\Controllers\FeedController::class, 'edit'])->name('feed.edit');
        Route::patch('/feed/{post}',    [\App\Http\Controllers\FeedController::class, 'update'])->name('feed.update');
        Route::delete('/feed/{post}',   [\App\Http\Controllers\FeedController::class, 'destroy'])->name('feed.destroy');
    });

    // ── Student-only ──
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
Route::get('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'show'])->name('profile');
Route::get('/sessions', [\App\Http\Controllers\Student\SessionController::class, 'index'])->name('sessions');
    });
});