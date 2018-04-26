<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cash extends Model
{
    protected $table = 'cash';
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

    static function getCash($skip,$limit,$flag,$opt,$orOpt,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Cash::orderBy('id', 'desc');
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
        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }
        foreach ($obj as $key => $val){
            $obj[$key]['access_name'] = ' ';
            foreach (config('base.access') as $k => $v){
                if ($val['access'] & $k){
                    $obj[$key]['access_name'] .= $v.' ';
                }
            }

            $obj[$key]['games_name'] = ' ';
            foreach (config('base.games') as $i => $j){
                if ($val['games'] & $i){
                    $obj[$key]['games_name'] .= $j.' ';
                }
            }

            $region = $val['region'];
            if ($region && $region_name = config('base.region')[$region]){
                $obj[$key]['region_name'] = $region_name;
            }else{
                $obj[$key]['region_name'] = '未知';
            }
        }
        return $obj;
    }

    static function getCashCount(){

        $count = Cash::count();

        return $count;
    }


}