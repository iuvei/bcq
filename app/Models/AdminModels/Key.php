<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    protected $table = 'key';

    protected $guarded = [];


    static function getKeys($skip,$limit,$flag,$opt,$betweenOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = Key::orderBy('status', 'desc')->orderBy('num', 'desc');
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
        return $obj;
    }

    static function getKeyCount(){

        $count = Key::count();

        return $count;
    }

}