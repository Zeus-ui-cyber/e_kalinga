<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommunityController;

use App\Http\Controllers\ReferralController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\SessionController;

use App\Http\Controllers\ReactionController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/', [LoginController::class, 'showLogin']);
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::get('/verify', [TwoFactorController::class, 'showForm'])->name('2fa.form');
    Route::post('/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify');
    Route::post('/verify/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE (GENERAL USER)
    |--------------------------------------------------------------------------
    */
// In routes/web.php
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | FEED (ALL USERS VIEW)
    |--------------------------------------------------------------------------
    */
    Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
    Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');
    // create post (admin only via middleware check inside controller or blade)
    Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');

    /*
    |--------------------------------------------------------------------------
    | REACTIONS (LIKE / EMOJI)
    |--------------------------------------------------------------------------
    */
    Route::post('/feed/{post}/react', [ReactionController::class, 'toggle'])
        ->name('feed.react');

    /*
    |--------------------------------------------------------------------------
    | COMMENTS
    |--------------------------------------------------------------------------
    */
    Route::post('/feed/{post}/comment', [CommentController::class, 'store'])
        ->name('comment.store');

    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])
        ->name('comment.destroy');

    /*
    |--------------------------------------------------------------------------
    | MESSAGES
    |--------------------------------------------------------------------------
    */
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{id}/send', [MessageController::class, 'send'])->name('messages.send');

    /*
    |--------------------------------------------------------------------------
    | COMMUNITY
    |--------------------------------------------------------------------------
    */
    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
    Route::post('/community/send', [CommunityController::class, 'send'])->name('community.send');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');

        Route::resource('students', StudentController::class);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // FEED MANAGEMENT (ADMIN ONLY)
        Route::patch('/feed/{post}', [FeedController::class, 'update'])->name('feed.update');
        Route::delete('/feed/{post}', [FeedController::class, 'destroy'])->name('feed.destroy');
    });
    /*
    |--------------------------------------------------------------------------
    | STUDENT ROUTES
    |--------------------------------------------------------------------------
    */
   Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
    Route::get('/profile',   [\App\Http\Controllers\Student\ProfileController::class, 'show'])->name('profile');
    Route::patch('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/sessions',  [\App\Http\Controllers\Student\SessionController::class, 'index'])->name('sessions');
});
});