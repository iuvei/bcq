<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExhibitionNews extends Model
{
    protected $table = 'show_news';

    public function news(){

        return $this->belongsTo('App\Models\News','nid','id');

    }

    public function getExhibitionNews($sid,$skip,$limit)
    {
        if (empty($limit)){

            return [];
        }
        $specialNewsList = ExhibitionNews::where('status',1)->where('sid',$sid)->skip($skip)->limit($limit)->with('news')->get();
        if ($specialNewsList->isEmpty()){
            return [];
        }else{
           foreach ($specialNewsList as $k => $v){
               if ($v->news){
                   $specialNewsList[$k]['title'] = $v->news['title'];
                   $specialNewsList[$k]['time'] = $v->news['updated_at']->diffForHumans();
               }
               unset($specialNewsList[$k]['news']);
           }
        }
        return $specialNewsList;
    }
}
