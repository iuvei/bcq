<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsPublish extends Model
{

    protected $table = 'news';

    protected $hidden = [];

    public function user_publish($uid,$skip,$limit){

        $publish = NewsPublish::whereNotIn('status',[-1,-3])->where('uid',$uid);

        $count = $publish->count();

        $publish = $publish->skip($skip)->limit($limit)->latest()->get();

        foreach($publish as $key=>$value){

            $publish[$key]->describe = $value->brief ? $value->brief : str_limit(strip_tags($value->content), $limit = 100, '...');

        }

        return ['list'=>$publish,'count'=>$count];

    }

}
