<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDataPublish extends Model
{

    protected $table = 'data';

    protected $hidden = [];

    public function user_publish($uid,$skip,$limit){

        $publish = UserDataPublish::where('status','<>',-1)->where('uid',$uid);

        $count = $publish->count();

        $publish = $publish->skip($skip)->limit($limit)->latest()->get();

        foreach($publish as $key=>$value){

            $publish[$key]->describe = $value->brief;

        }

        return ['list'=>$publish,'count'=>$count];

    }

}