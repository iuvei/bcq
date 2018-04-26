<?php

namespace App\Models\AdminModels;

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

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });

        Relation::morphMap([
            'news' => 'App\Models\AdminModels\News',
            'report' => 'App\Models\AdminModels\Report',
            'business' => 'App\Models\AdminModels\Business',
            'platform' => 'App\Models\AdminModels\Platform',
            'notice' => 'App\Models\AdminModels\Notice',
            'data' => 'App\Models\AdminModels\Data',
            //'banner' => 'App\Models\AdminModels\Banner',
            'gamestore' => 'App\Models\AdminModels\Gamestore',
        ]);
    }

    public function Slide(){

        return $this->morphTo();

    }

    static function getSlide($skip,$limit,$flag,$opt,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Slide::orderBy('id', 'desc');
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


        $obj = $obj->load(['Slide']);

        return $obj;
    }

    static function getSlideCount(){

        $count = Slide::count();

        return $count;
    }

}