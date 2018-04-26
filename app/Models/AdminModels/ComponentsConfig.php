<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ComponentsConfig extends Model
{
    protected $table = 'components_config';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });
    }

    static function getComponentsConfig($orderField)
    {
        $obj = ComponentsConfig::orderBy($orderField, 'desc')->get();
        return $obj;
    }

    static function getComponentsConfigCount(){

        $count = ComponentsConfig::count();

        return $count;
    }
}
