<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Question extends Model
{
    protected $table = 'question';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('status',[0,1]);
        });
    }

    public function useAnswer(){

        return $this->belongsTo('App\Models\AdminModels\Answer','rid','id');

    }

    public function answer(){

        return $this->hasMany('App\Models\AdminModels\Answer','qid','id');

    }

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','uid','id');

    }

    public function order()
    {
        return $this->morphMany('App\Models\AdminModels\Order', 'pay');
    }

    public function Fall()
    {
        return $this->morphMany('App\Models\AdminModels\Fall', 'Fall','model','cid');
    }

    static function getQuestion($skip,$limit,$flag,$orOpt=array(),$betweenOpt=array()){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Question::orderBy('id', 'desc');
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

        $obj = $obj->load(['useAnswer' => function ($query) {
            $query->where('status', 1);
        }]);


        return $obj;
    }

    static function getQuestionCount(){

        $count = Question::count();

        return $count;
    }
}
