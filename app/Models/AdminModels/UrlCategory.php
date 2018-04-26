<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UrlCategory extends Model
{
    protected $table = 'url_category';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });
    }

    static public function getCategory($statusSign,$status,$orderField)
    {
        $categorys = UrlCategory::where('status',$statusSign,$status)->orderBy($orderField, 'desc')->get();
        return $categorys;
    }

    static function getCategoryCount($statusSign,$status){

        $count = UrlCategory::where('status',$statusSign,$status)->count();
        return $count;
    }

}
