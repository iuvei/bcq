<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCollection extends Model
{
    //
    protected $table = 'news_collection';

    protected $hidden = ['created_at','status'];

    public function news(){

        return $this->belongsTo('App\Models\News','nid','id');

    }

    public function user_collection($uid,$skip,$limit){

    	$collection = NewsCollection::where('status',1)->where('uid',$uid);

        $count = $collection->count();

        $collection = $collection->skip($skip)->limit($limit)->latest()->get();

    	foreach($collection as $key=>$value){

    		$collection[$key]->title = $value->news->title;

    		$collection[$key]->brief = $value->news->brief;

    		unset($collection[$key]->news);
    	}

    	return ['list'=>$collection,'count'=>$count];
    }

}
