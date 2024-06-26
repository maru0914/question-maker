<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Facades\Pulse;

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
        JsonResource::withoutWrapping();

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
