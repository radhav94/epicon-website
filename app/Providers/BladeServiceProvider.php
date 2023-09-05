<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
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
        Blade::directive('notloggedin', function () {
            return "<?php if(!isUserLoggedIn()): ?>";
        });

        Blade::directive('endnotloggedin', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('loggedin', function () {
            return "<?php if(isUserLoggedIn()): ?>";
        });

        Blade::directive('elseloggedin', function () {
            return "<?php else: ?>";
        });

        Blade::directive('endloggedin', function () {
            return "<?php endif; ?>";
        });
    }
}
