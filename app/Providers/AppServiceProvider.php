<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip() ?: 'contact');
        });

        View::composer(['components.site-footer', 'components.site-header', 'layouts.app'], function ($view): void {
            $view->with('settings', SiteSetting::current());
        });
    }
}
