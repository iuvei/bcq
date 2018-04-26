<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Show extends Model
{
    protected $table = 'show';
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
            $query->whereIn('show.status',[0,1]);
        });
    }

    public function show_news(){

        return $this->hasMany('App\Models\AdminModels\ShowNews','sid','id');

    }


    static function getShow($skip,$limit,$flag,$opt,$orOpt,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Show::orderBy('id', 'desc');
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
            $obj[$key]['cname'] = ' ';
            foreach (config('base.games') as $k => $v){
                if ($val['cid'] & $k){
                    $obj[$key]['cname'] .= $v.' ';
                }
            }
            $obj[$key]['starttime'] = date('Y-m-d H:i:s',$val['starttime']);
            $obj[$key]['endtime'] = date('Y-m-d H:i:s',$val['endtime']);
        }
        return $obj;
    }

    static function getShowCount(){

        $count = Show::count();

        return $count;
    }


}