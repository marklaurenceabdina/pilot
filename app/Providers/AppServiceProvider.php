<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\UpdateLastLogin;
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
        //
    }
}

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            UpdateLastLogin::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
