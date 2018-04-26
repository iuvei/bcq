<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_category';
    protected $guarded = [];

    static public function getCategory($statusSign,$status,$orderField)
    {
        $categorys = NewsCategory::where('status',$statusSign,$status)->orderBy($orderField, 'desc')->get();
        return $categorys;
    }

    static function getCategoryCount($statusSign,$status){

        $count = NewsCategory::where('status',$statusSign,$status)->count();
        return $count;
    }

}
