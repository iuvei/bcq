<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AdvertisingSystem extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'App\Providers\AdvertisingSystem\AdService';
    }

}