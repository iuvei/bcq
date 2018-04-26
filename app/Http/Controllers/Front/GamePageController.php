<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use DisplaySystem;
use App\Models\GameStore;
class GamePageController extends Controller
{
    public function render(){

        $gameStoreCategories = $this->getList('GameStoreCategory',0,10,[]);

        $getGameStoreList = $this->getList('GameStore',0,config('etc.game.gamestore.render_limit'),[]);

        $render = [
            'gameStoreCategories'=>$gameStoreCategories,
            'getGameStoreList'=>$getGameStoreList
        ];

        echo json_encode($render);
    }

    public function filter(Request $request){

        $page = $request->input('page');

        $cid = $request->input('cid');   

        $page_info = page_helper($page,config('etc.game.gamestore.render_limit'),config('etc.game.gamestore.limit'));

        if ($cid) {

            $getGameStoreList = $this->getList('GameStoreCO',$page_info['skip'],$page_info['limit'],['cid'=>$cid]);   

        }else{
            
            $getGameStoreList = $this->getList('GameStore',$page_info['skip'],$page_info['limit'],['cid'=>$cid]);
        
        }
        
        echo json_encode($getGameStoreList);

    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}
