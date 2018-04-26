<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class GamestoreCategory extends Model
{
    protected $table = 'gamestore_category';
    protected $guarded = [];

    static public function getCategory()
    {
        $categorys = GamestoreCategory::whereIn('status',[0,1])->orderBy('sort', 'desc')->get();
        return $categorys;
    }

    static function getCategoryCount($statusSign,$status){

        $count = GamestoreCategory::where('status',$statusSign,$status)->count();
        return $count;
    }

}
