<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RolesSerrviceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('roles', function ($app) {
            return new Roles();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
