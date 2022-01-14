<?php

namespace IpnuIppnu\Package\Sso;

use Illuminate\Support\ServiceProvider;
use IpnuIppnu\Package\Sso\Service;
use IpnuIppnu\Package\Sso\Services\Auth;
use IpnuIppnu\Package\Sso\Services\User;

class Provider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('auth_sso', function(){
            return new Service;
        });

        $this->app->singleton(Auth::class, function(){
            return new Auth;
        });

        $this->app->singleton(User::class, function(){
            return new User;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
