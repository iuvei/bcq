<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCollection extends Model
{
    //
    protected $table = 'question_collection';    

    protected $hidden = ['created_at','status'];   

    public function question(){

        return $this->belongsTo('App\Models\Question','qid','id');
        
    }

    public function user_collection($uid,$skip,$limit){

    	$collection = QuestionCollection::where('status',1)->where('uid',$uid);

        $count = $collection->count();

        $collection = $collection->skip($skip)->limit($limit)->latest()->get();

    	foreach($collection as $key=>$value){

    		$collection[$key]->title = $value->question->title;

            $collection[$key]->describe = $value->question->describe;

    		$collection[$key]->comment = $value->question->answers->count();

    		unset($collection[$key]->question);
    	}    	

    	return ['list'=>$collection,'count'=>$count];  

    }

}
