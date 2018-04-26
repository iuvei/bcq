<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Flash extends Model
{
    protected $table = 'flash';
    protected $guarded = [];

    public function Fall()
    {
        return $this->morphMany('App\Models\AdminModels\Fall', 'Fall','model','cid');
    }

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('flash.status',[0,1]);
        });
    }

    static function getFlash($skip,$limit,$orOpt=array(),$betweenOpt=array()){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Flash::latest()->orderBy('updated_at','desc')->orderBy('sort','desc');
        if (!empty($betweenOpt)){
            foreach ($betweenOpt as $k => $v){
                $query = $query->whereBetween($k,$v);
            }
        }
        if (!empty($orOpt)){
            $query = $query->where(function ($query) use($orOpt){
                foreach ($orOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        }
        $obj = $query->skip($skip)->limit($limit)->get();
        return $obj;
    }

    static function getFlashCount(){

        $count = Flash::count();

        return $count;
    }
}
