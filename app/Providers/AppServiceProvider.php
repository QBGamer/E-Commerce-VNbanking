<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Support\DemoData;
use App\Http\Controllers\ControlPanel\CPStoreController;

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
        View::share(CPStoreController::data());
        View::share(DemoData::data());
        Gate::define('access-control-panel', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });
        Gate::define('access-control-panel-admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}
