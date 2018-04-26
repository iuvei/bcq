<?php

namespace App\Providers\AdvertisingSystem;

interface AdContract{

    public function getAds($page_id);//获取某页面的所有在展示的广告

}