<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'income';
    protected $guarded = [];

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','uid','id');

    }

    static function getIncome($skip,$limit,$flag,$orOpt=array(),$betweenOpt=array()){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Income::orderBy('id', 'desc');
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

        $obj = $obj->load('user');
        return $obj;
    }

    static function getIncomeCount(){

        $count = Income::count();

        return $count;
    }
}
