<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CAS\TicketLocker;
use App\Services\CAS\UserLogin;
use Leo108\CAS\Contracts\Interactions\UserLogin as UserLoginContract;
use Leo108\CAS\Contracts\TicketLocker as TicketLockerContract;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(UserLoginContract::class, function ($app) {
            return new UserLogin();
        });
        $this->app->singleton(TicketLockerContract::class, function ($app) {
            return new TicketLocker();
        });
    }
}
