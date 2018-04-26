<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPosition extends Model
{
    protected $table = 'banner_position';

    public function banners(){

        return $this->hasMany('App\Models\Banner','pid','id');

    }

    public function getAds($page_id){

        $adPositions = BannerPosition::where('pid',$page_id)->get();

        $ads = [];

        if (!$adPositions->isEmpty()){

            foreach ($adPositions as $adPosition){

                if (!empty($adPosition->banners->where('status',1))){

                    $ads[$adPosition->lid] = $adPosition->banners->where('status',1)->first();

                }
            }
        }
        return $ads;
    }
}