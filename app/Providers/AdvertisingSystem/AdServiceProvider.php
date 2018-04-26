<?php

namespace App\Providers\AdvertisingSystem;

use Illuminate\Support\ServiceProvider;
use App\Models\BannerPosition as BannerPosition;
use App\Providers\AdvertisingSystem\AdService as AdService;
class AdServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Providers\AdvertisingSystem\AdService',function ($app){
            $ad_obj = new BannerPosition();
            $AdService = new AdService($ad_obj);
            return $AdService;
        });
    }

    public function provides()
    {
        return ['App\Providers\AdvertisingSystem\AdService'];
    }

}
