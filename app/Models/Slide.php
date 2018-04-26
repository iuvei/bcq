<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class Slide extends Model
{
    protected $table = 'slide';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    static function getSlide($limit){

        $obj = Slide::where('type','&',1)->where('status',1)->orderBy('sort', 'desc')->orderBy('created_at', 'desc')->limit($limit)->get();

        return $obj;
    }

    static function getSecondary($limit){

        $obj = Slide::where('type','&',2)->where('status',1)->orderBy('sort', 'desc')->orderBy('created_at', 'desc')->limit($limit)->get();

        return $obj;
    }

}