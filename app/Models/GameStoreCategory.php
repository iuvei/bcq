<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameStoreCategory extends Model
{
    protected $table = 'gamestore_category';

    public function gamestore(){

        return $this->hasMany('App\Models\GameStore','cid','id');

    }

    public function getGameStoreCategoryList($skip,$limit,$opt){

        if (!$limit){
            
            return [];
        }
        
        $categories = GameStoreCategory::where('status',1)->select('id','gname','image');

        $categories = $categories->skip($skip)->limit($limit)->orderBy('sort','desc')->get();

        return $categories;

    }
}