<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformPublish extends Model
{

    protected $table = 'platform';

    protected $hidden = ['created_at','validitytime'];

    public function user_publish($uid,$skip,$limit){

        $publish = PlatformPublish::where('status','<>',-1)->where('uid',$uid);

        $count = $publish->count();

        $publish = $publish->skip($skip)->limit($limit)->select('id','title','status','updated_at','brief','type')->latest()->get();

        foreach($publish as $key=>$value){

            $publish[$key]->describe = str_limit(strip_tags($value->content), $limit = 100, '...');

            $publish[$key]->flush = get_cache('Platform'.'-'.$value->id);

        }

        return ['list'=>$publish,'count'=>$count];

    }

}


