<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $guarded = [];

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

    static function getFeedback($Opt=array()){
        $query = Feedback::orderBy('id', 'desc');
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

    static function getFeedbackCount(){

        $count = Feedback::count();

        return $count;
    }
}
