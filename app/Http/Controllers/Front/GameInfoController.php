<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DisplaySystem;
class GameInfoController extends Controller
{
	public function render(){
		        //游戏接口服务
        $gameList = $this->getList('GameStoreCategory',0,6,['no_detail'=>1]);

        $gameStore = config('base.access');

        $gameInfo = $this->getList('Micro',0,20,['utype'=>'1']);

        $render = [
            'gameList'=>$gameList,
            'gameStore'=>$gameStore,
            'gameInfo'=>$gameInfo
        ];

        echo json_encode($render);
	}

	public function GetMore(Request $request){

		$page = $request->input('page');

		$store = $request->input('store');

		$uid = '';

		if (!empty($store)) {
			
			$game = get_model_obj('GameInfo')->where('sid',$store)->first();

			if (empty($game)) {
				echo json_encode([]);
				die;
			}
			
			$uid = $game->uid;
		}

		$opt = ['utype'=>'1'];

		if ($uid) {

			$opt['uid'] = $uid;

		}

		$limit = 20;

	    $gameInfo = $this->getList('Micro',$page,$limit,$opt);

        echo json_encode($gameInfo);	

	}

	public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }
}
