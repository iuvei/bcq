<?php

namespace App\Providers\AdvertisingSystem;
use App\Providers\AdvertisingSystem\AdContract as AdContract;

class AdService implements AdContract{

    private $ad_obj;

    public function __construct($ad_obj)
    {
        $this->ad_obj = $ad_obj;
    }

    public function getAds($page_id){

        $ads = $this->ad_obj->getAds($page_id);

        return $ads;

    }

}