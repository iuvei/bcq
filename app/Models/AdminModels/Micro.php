<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Micro extends Model
{
    protected $table = 'micro';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('micro.status',[0,1]);
        });
    }

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','uid','id');

    }

    public function Fall()
    {
        return $this->morphMany('App\Models\AdminModels\Fall', 'Fall','model','cid');
    }

    static function getMicro($skip,$limit,$opt=array(),$betweenOpt=array()){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Micro::orderBy('id', 'desc');
        if (!empty($opt)){
            foreach ($opt as $k => $v){
                if(is_array($v) && $v[1]){
                    $query = $query->where($k,$v[0],$v[1]);
                }elseif(!is_array($v) && $v){
                    $query = $query->where($k,$v);
                }
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
        $obj = $query->skip($skip)->limit($limit)->has('user')->get()->load('user');
        foreach ($obj as $key => $val){
            $obj[$key]['contentMin'] = mb_substr( $val['content'], 0, 100) ;
        }
        return $obj;
    }

    static function getMicroCount($statusSign,$status){

        $count = Micro::where('status',$statusSign,$status)->count();

        return $count;
    }
}
