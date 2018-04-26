<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class Order extends Model
{
    protected $table = 'order';
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

        Relation::morphMap([
            'data' => 'App\Models\AdminModels\Data',
            //'task' => 'App\Models\AdminModels\Task',
            'report' => 'App\Models\AdminModels\Report',
            'question' => 'App\Models\AdminModels\Question',
        ]);
    }

    public function pay(){

        return $this->morphTo();

    }

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','uid','id');

    }

    static function getOrder($skip,$limit,$flag,$opt,$payOpt,$userOpt,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Order::orderBy('id', 'desc');
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

        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }


        $obj = $obj->load(['user' => function ($query) use($userOpt) {
            $query->Where(function ($query) use($userOpt) {
                foreach ($userOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        },'pay' => function ($query) use($payOpt) {
            foreach ($payOpt as $k => $v){
                if(is_array($v) && $v[1]){
                    $query->orWhere($k,$v[0],$v[1]);
                }elseif(!is_array($v) && $v){
                    $query->orWhere($k,$v);
                }
            }
        }]);

        foreach ($obj as $key => $val){
            if(!$val['user'] || !$val['pay']){
                unset($obj[$key]);
            }
        }

        return $obj;
    }

    static function getOrderCount(){

        $count = Order::count();

        return $count;
    }

}