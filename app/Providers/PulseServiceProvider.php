<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Facades\Pulse;

class PulseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->is_admin;
        });

        Pulse::user(fn ($user) => [
            'name' => $user->username,
            'extra' => $user->email,
            'avatar' => sprintf('https://gravatar.com/avatar/%s?d=mp', hash('sha256', trim(strtolower($user['email'])))),
        ]);
    }
}
