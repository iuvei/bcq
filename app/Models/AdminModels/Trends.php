<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Trends extends Model
{
    protected $table = 'trends';
    protected $guarded = [];

    public function Fall()
    {
        return $this->morphMany('App\Models\AdminModels\Fall', 'Fall','model','cid');
    }

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('trends.status',[0,1]);
        });
    }

    static function getTrends($skip,$limit,$opt=array(),$orOpt=array(),$betweenOpt=array()){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Trends::orderBy('id', 'desc');
        if (!empty($opt)){
            foreach ($opt as $k => $v){
                if(is_array($v) && $v[1]){
                    $query = $query->where($k,$v[0],$v[1]);
                }elseif(!is_array($v) && $v){
                    $query = $query->where($k,$v);
                }
            }
        }
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
        foreach ($obj as $key => $val){
            $obj[$key]['type_name'] = ' ';
            foreach (config('base.trendsType') as $k => $v){
                if ($val['type'] & $k){
                    $obj[$key]['type_name'] .= $v.' ';
                }
            }
        }
        return $obj;
    }

    static function getTrendsCount($statusSign,$status){

        $count = Trends::where('status',$statusSign,$status)->count();

        return $count;
    }
}
