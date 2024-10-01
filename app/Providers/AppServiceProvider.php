<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
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
        Vite::prefetch(concurrency: 3);

        Gate::define('admin', function (User $user, $permName) {
            return true;
        });

        Gate::define('attendant', function (User $user, $permName) {
            $allow = ['menu:scheduling.index'];
            return in_array($permName, $allow);
        });

        Gate::define('patient', function (User $user, $permName) {
            $allow = ['menu:scheduling.index'];
            return in_array($permName, $allow);
        });

        Gate::define('doctor', function (User $user, $permName) {
            $allow = ['menu:scheduling.index', 'menu:availability.index'];
            return in_array($permName, $allow);
        });

        Gate::define('user_gate', function (User $user, $permName) {
            foreach ($user->roles as $roles) {
                if (Gate::check($roles->gate_name, $permName)) return true;
            }
            return false;
        });
    }
}
