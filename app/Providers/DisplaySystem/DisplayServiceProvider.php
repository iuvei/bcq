<?php

namespace App\Providers\DisplaySystem;

use Illuminate\Support\ServiceProvider;
use App\Providers\DisplaySystem\DisplayService as DisplayService;
class DisplayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    protected $defer = true;

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
        $this->app->bind('App\Providers\DisplaySystem\DisplayService',function ($app){
            $display = new DisplayService();
            return $display;
        });
    }

    public function provides()
    {
        return ['App\Providers\DisplaySystem\DisplayService'];
    }


}
