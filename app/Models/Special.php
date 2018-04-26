<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class Special extends Model
{
    protected $table = 'special';

    public function special_news(){

        return $this->hasMany('App\Models\SpecialNews','sid','id');

    }

    public function getSpecialList($skip,$limit,$opt)
    {
        if (empty($limit)){

            return [];
        }

        $specialList = Special::where('status',1);

        if (isset($opt['hot'])){
            $specialList = $specialList->where('hot',1);
        }

        if (isset($opt['order_by'])){
            $specialList = $specialList->orderBy($opt['order_by'],'desc');
        }

        $specialList = $specialList->latest()->skip($skip)->limit($limit)->get();

        if (!$specialList->isEmpty()){

            foreach ($specialList as $key=>$special){
                $specialList[$key]->content = strip_tags($special->content);
                $specialList[$key]->time = $special->created_at->diffForHumans();
                //避免状态暴露
                unset($specialList[$key]->status);

            }
        }
        return $specialList;
    }

    public function getDetails($sid){
        $special = Special::where('id',$sid)->where('status',1)->select('id','sort','hot','title','image','content','status','created_at')->first();
        if (!$special){
            return [];
        }else{
            $special->created_at->diffForHumans();
        }

        return $special;
    }   

    public function get_hot_special(){

        $week_ago = date('Y-m-d', strtotime('-7 days'));

        $hot_special = Special::where('status',1)

        ->where('hot',1)

        ->where('updated_at','>',$week_ago)

        ->select('id','title')

        ->orderBy('sort','desc')

        ->latest()

        ->limit(10)

        ->get();

        return $hot_special;

    }
}