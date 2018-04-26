<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Answer extends Model
{
    protected $table = 'question_answer';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('question_answer.status',[0,1]);
        });
    }

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','uid','id');

    }

    public function question(){

        return $this->belongsTo('App\Models\AdminModels\Question','qid','id');

    }

    static function getAnswer($Opt=array()){
        $query = Answer::orderBy('id', 'desc');
        if (!empty($Opt)){
            foreach ($Opt as $k => $v){
                if(is_array($v) && $v[1]){
                    $query->Where($k,$v[0],$v[1]);
                }elseif(!is_array($v) && $v){
                    $query->Where($k,$v);
                }
            }
        }

        $obj = $query->get();
        return $obj;
    }

    static function getAnswerCount(){

        $count = Answer::count();

        return $count;
    }

    static function getAllAnswer($skip,$limit,$flag,$orOpt,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Answer::orderBy('id', 'desc');

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
        return $obj;
    }

    static function getAllAnswerCount(){

        $count = Answer::whereIn('status',[0,1])->count();

        return $count;
    }
}
