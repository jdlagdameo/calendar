<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        var_dump(\Request::secure());
        //
        if($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            
            \Config::set('session.secure', true); // override session config for https
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
