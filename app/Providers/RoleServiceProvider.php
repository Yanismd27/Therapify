<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('role', function ($app) {
            return new \App\Http\Middleware\CheckRole;
        });
    }

    public function boot()
    {
        //
    }
}