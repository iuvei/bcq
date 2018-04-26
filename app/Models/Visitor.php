<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
	public function user(){
        return $this->hasOne('App\Models\User','id','vuid');
    }

    protected $table = 'visitor'; 

    public function GetVisitor($auid){

    	$visitors = Visitor::where('auid',$auid)

			    	->where('status',1)

			    	->orderBy('updated_at','desc')

			    	->select('vuid')

			    	->distinct()

			    	->limit(10)

			    	->get();


		foreach ($visitors as $key=>$visitor) {

			if (empty($visitor->user->id)) {

				unset($visitors[$key]);

				continue;
			}

			$visitors[$key]->uid = $visitor->user->id;

			$visitors[$key]->username = $visitor->user->username;

			$visitors[$key]->level_id = $visitor->user->level_id;

			$visitors[$key]->image = $visitor->user->image;

			unset($visitors[$key]->user);
		}	

    	return  $visitors;

    }
}
