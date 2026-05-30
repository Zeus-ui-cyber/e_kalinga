<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // CRITICAL IMPORT

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS when running live on production (Railway/Cloudflare)
        if (config('app.env') === 'production' || env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}