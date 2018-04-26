<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class SpecialNews extends Model
{
    protected $table = 'special_news';

    public function news(){

        return $this->belongsTo('App\Models\News','nid','id');

    }

    public function getSpecialNews($sid,$skip,$limit)
    {
        if (empty($limit)){

            return [];
        }
        $specialNewsList = SpecialNews::where('status',1)->where('sid',$sid)->latest()->skip($skip)->limit($limit)->with('news.user')->get();
        if ($specialNewsList->isEmpty()){
            return [];
        }else{
           foreach ($specialNewsList as $k => $v){
               if ($v->news){
                   $specialNewsList[$k]['authorName'] = $v->news->user->username;

                   $specialNewsList[$k]['title'] = $v->news['title'];

                   $specialNewsList[$k]['uid'] = $v->news['uid'];
               }
               unset($specialNewsList[$k]['news']);
           }
        }
        return $specialNewsList;
    }
}
