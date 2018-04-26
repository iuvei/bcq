<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class Fall extends Model
{
    protected $table = 'falls';
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
            $query->whereIn('falls.status',[0,1]);
        });

        Relation::morphMap([
            'News' => 'App\Models\AdminModels\News',
            'Report' => 'App\Models\AdminModels\Report',
            'Business' => 'App\Models\AdminModels\Business',
            'Platform' => 'App\Models\AdminModels\Platform',
            'Trend' => 'App\Models\AdminModels\Trends',
            'Flash' => 'App\Models\AdminModels\Flash',
            'UserData' => 'App\Models\AdminModels\Data',
            'Question' => 'App\Models\AdminModels\Question',
            'Micro' => 'App\Models\AdminModels\Micro',
        ]);
    }

    public function Fall(){

        return $this->morphTo('Fall','model','cid');

    }

    static function getFall($skip,$limit,$flag,$opt,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }

        $query = Fall::orderBy('updated_at', 'desc');
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

        $obj = $obj->load(['Fall']);

        return $obj;
    }

    static function getFallCount(){

        $count = Fall::count();

        return $count;
    }

}