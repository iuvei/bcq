<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionPublish extends Model
{

    protected $table = 'question';

    protected $hidden = [];

    public function user_publish($uid,$skip,$limit){

    	$publish = QuestionPublish::where('status','<>',-1)->where('uid',$uid);

        $count = $publish->count();

        $publish = $publish->skip($skip)->limit($limit)->latest()->get();

    	return ['list'=>$publish,'count'=>$count];

    }

}
