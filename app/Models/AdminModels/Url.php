<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Url extends Model
{
    protected $table = 'url';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });
    }

    public function category(){

        return $this->belongsTo('App\Models\AdminModels\UrlCategory','ucid','id');

    }

    static function getUrl($orderField)
    {
        $obj = Url::orderBy($orderField, 'desc')->get()->load('category');
        return $obj;
    }

    static function getUrlCount($statusSign,$status){

        $count = Url::where('status',$statusSign,$status)->count();

        return $count;
    }
}
