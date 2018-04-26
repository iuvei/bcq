<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameStoreCO extends Model
{
	protected $table = 'gamestore_c_o';

	public function game(){

        return $this->belongsTo('App\Models\GameStore','gid','id');

    }

    public function getGameStoreCOList($skip,$limit,$opt){

	    $gameStoreList = GameStoreCO::where('status',1);

	    if (isset($opt['cid'])&&$opt['cid']) {

	        $gameStoreList = $gameStoreList->where('cid',$opt['cid']);            
	    }

	    $gameStoreList = $gameStoreList->select('gid');

	    $gameStoreList = $gameStoreList->skip($skip)->limit($limit)->orderBy('sort','desc')->latest()->get();

		$gameList = [];	    

	    foreach($gameStoreList as $key=>$value){

	    	if ($value->game->status ==1) {
	    		$gameList[] = $value->game;
	    	}
	    }

	    return $gameList;
	}	
}