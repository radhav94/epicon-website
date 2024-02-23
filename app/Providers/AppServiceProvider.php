<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('csrf', function () {
            return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        });

        $env = strtoupper(env('APP_ENV'));
        if ($env == 'DEV' || $env == 'STAGE' || $env == 'PRODUCTION') {
            URL::forceScheme('https');
        }

        view()->composer('partials.language_switcher', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });
    }
}
