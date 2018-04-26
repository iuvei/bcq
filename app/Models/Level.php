<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';
    protected $guarded = [];

    static function getLevel($statusSign,$status,$orderField)
    {
        $obj = Level::where('status',$statusSign,$status)->orderBy($orderField, 'desc')->get();
        return $obj;
    }

    static function getLevelCount($statusSign,$status){

        $count = Level::where('status',$statusSign,$status)->count();

        return $count;
    }
}
