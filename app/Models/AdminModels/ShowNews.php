<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShowNews extends Model
{
    //
    protected $table = 'show_news';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });
    }

    public function news(){

        return $this->belongsTo('App\Models\AdminModels\News','nid','id');

    }

    static function getShowNews($skip,$limit,$flag,$sSearch,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = ShowNews::whereHas('user', function ($query) use($sSearch,$betweenOpt){
            if ($sSearch){
                $query->where('username','like', '%'.$sSearch.'%');
            }
            if (!empty($betweenOpt)) {
                foreach ($betweenOpt as $k => $v) {
                    $query->whereBetween($k, $v);
                }
            }
        });

//        $query = ShowNews::has('user');

        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }

        $obj = $obj->load('user');
        return $obj;
    }

    static function getShowNewsCount(){

        $count = ShowNews::count();

        return $count;
    }

    static function getHasNews($skip,$limit,$flag,$orOpt=array(),$betweenOpt=array(),$sid){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = ShowNews::whereHas('news', function ($query) use($sid) {
            $query->where('sid', $sid);
        });
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

        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }
        $obj = $obj->load('news');
        return $obj;

    }

    static function getHasNewsCount($sid){

        $count = ShowNews::whereHas('news', function ($query) use($sid) {
            $query->where('sid', $sid);
        })->count();

        return $count;
    }

}
