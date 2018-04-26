<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PbCollection extends Model
{
    //
    protected $table = 'pb_collection';    

    protected $hidden = ['created_at','status'];       
       
    public function platform(){

        return $this->belongsTo('App\Models\Platform','pbid','id');

    }

    public function business(){

        return $this->belongsTo('App\Models\Business','pbid','id');

    }

    public function user_collection($uid,$skip,$limit){

    	$collection = PbCollection::where('status',1)->where('uid',$uid)->where('type',1);

        $count = $collection->count();

    	$collection= $collection->skip($skip)->limit($limit)->latest()->get();

    	foreach($collection as $key=>$value){

    		//if ($value->type == 1) {

    		$collection[$key]->title = $value->business->title;

    		$collection[$key]->brief = $value->business->brief;  

    		$collection[$key]->confirm = $value->business->confirm;  

    		$collection[$key]->category = $value->business->category($value->business->bid);

            $collection[$key]->category = $value->business->category($value->business->bid);

			unset($collection[$key]->business);

    		//}

    		/*else{

	    		$collection[$key]->title = $value->platform->title;

	    		$collection[$key]->brief = $value->platform->brief;

	    		$collection[$key]->confirm = $value->platform->confirm;
    			
	    		foreach (config('base.games') as $k => $v){
		            if ($k & $value->games){
		                $collection[$key]->game[] = $v;
		            }
		        } 	

    			unset($collection[$key]->platform);
    		}*/
    	}

    	$collection = $collection->sortByDesc('confirm');

    	return ['list'=>$collection,'count'=>$count];    		

    }    
}