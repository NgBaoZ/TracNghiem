<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

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
    
    public function boot(UrlGenerator $url)
    {
        // Buộc sử dụng HTTPS nếu APP_ENV là production (hoặc tương đương)
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
    }
}
