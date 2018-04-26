<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DataComment extends Model
{
    protected $table = 'data_comment';
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

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','uid','id');

    }

    public function data(){

        return $this->belongsTo('App\Models\AdminModels\Data','did','id');

    }

    public function comment(){

        return $this->belongsTo('App\Models\AdminModels\DataComment','dcid','id');

    }

    static function getDataComment($skip,$limit,$flag,$opt,$orOpt,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = DataComment::orderBy('id', 'desc');
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
        $obj = $obj->load('user','data','comment');
        return $obj;
    }

    static function getDataCommentCount(){

        $count = DataComment::count();

        return $count;
    }

}