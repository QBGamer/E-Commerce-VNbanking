<?php

namespace App\Providers;

use App\Support\DemoData;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        View::share(DemoData::data());
        Gate::define('access-control-panel', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });
    }
}
