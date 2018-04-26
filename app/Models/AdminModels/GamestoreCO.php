<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class GamestoreCO extends Model
{
    protected $table = 'gamestore_c_o';
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

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });
    }

    public function category(){

        return $this->belongsTo('App\Models\AdminModels\GamestoreCategory','cid','id');

    }
    public static function getGamestoreCOList($gid){
        $object = GamestoreCO::where('gid',$gid)->where('status',1)->with('category')->get();
        return $object;
    }
}