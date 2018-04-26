<?php

namespace App\Providers\Authentication;

use Illuminate\Support\ServiceProvider;
use App\Providers\Authentication\AuthService as AuthService;
class AuthServiceProvider extends ServiceProvider
{

    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Providers\Authentication\AuthService',function ($app){
            $authService = new AuthService;
            return $authService;
        });
    }

    public function provides()
    {
        return ['App\Providers\Authentication\AuthService'];
    }
}
