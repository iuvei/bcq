<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Level extends Model
{
    protected $table = 'level';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });
    }

    static function getLevel($orderField)
    {
        $obj = Level::orderBy($orderField, 'desc')->get();
        return $obj;
    }

    static function getLevelCount(){

        $count = Level::count();

        return $count;
    }
}
