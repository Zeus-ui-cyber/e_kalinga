<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommunityController;


// ── Missing imports (ADDED ONLY) ──
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\SessionController;

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

   // Profile Settings (Both roles)
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ── Org Feed (view for all users) ──
    Route::get('/feed',        [FeedController::class, 'index'])->name('feed.index');
    Route::get('/feed/{post}', [FeedController::class, 'show'])->name('feed.show');

    // ⭐ ADDED (IMPORTANT)
    // Allow posting via compose form (works with Blade form)
    Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');

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

        Route::resource('students', StudentController::class);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // Feed management
        Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');
        Route::patch('/feed/{post}', [FeedController::class, 'update'])->name('feed.update');
        Route::delete('/feed/{post}', [FeedController::class, 'destroy'])->name('feed.destroy');
    });

    // ── Student-only ──
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {

        Route::get('/profile',  [StudentProfileController::class, 'show'])->name('profile');
        Route::patch('/profile',[StudentProfileController::class, 'update'])->name('profile.update');

        Route::get('/sessions', [SessionController::class, 'index'])->name('sessions');
    });

});