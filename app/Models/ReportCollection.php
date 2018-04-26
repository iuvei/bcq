<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCollection extends Model
{
    //
    protected $table = 'report_collection';    

    protected $hidden = ['created_at','status'];

    public function report(){

        return $this->belongsTo('App\Models\Report','rid','id');

    }

    public function user_collection($uid,$skip,$limit){

    	$collection = ReportCollection::where('status',1)->where('uid',$uid);

        $count = $collection->count();

        $collection = $collection->skip($skip)->limit($limit)->latest()->get();

    	foreach($collection as $key=>$value){

    		$collection[$key]->title = $value->report->title;

    		$collection[$key]->brief = $value->report->brief;

    		unset($collection[$key]->report);
    	}

    	return ['list'=>$collection,'count'=>$count];  

    }

}
