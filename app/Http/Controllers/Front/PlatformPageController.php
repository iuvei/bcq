<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use App\Models\Platform;
class PlatformPageController extends Controller
{
    //代理招商页面
    public function render(){

        $adsList = AdvertisingSystem::getAds(config('etc.platform.page_id'));//获取该页所有广告位广告信息
        //choice选择列表  游戏种类  结算方式
        $gameCatList = config('etc.games');
        //结算方式
        $settlementList = config('etc.settlement');
        //游戏接口服务
        $gameList = $this->getList('GameStoreCategory',0,6,['no_detail'=>1]);
        //平台
        $proxyList = $this->getList('Platform',0,config('etc.platform.platform.render_limit'),['type'=>1]);
        //代理
        $tradeList = $this->getList('Platform',0,config('etc.platform.platform.render_limit'),['type'=>2]);

        $render = [
            'adsList'=>$adsList,
            'proxyList'=>$proxyList,
            'tradeList'=>$tradeList,
            'gameCatList'=>$gameCatList,
            'gameList'=>$gameList,
            'settlementList'=>$settlementList
        ];

        echo json_encode($render);
    }

    public function filter(Request $request){//代理招商的分页要用filter来筛选

        $games = $request->input('games')?array_sum($request->input('games')):0;

        $settlement = $request->input('settlement');

        $confirm = $request->input('confirm'); 

        $type = $request->input('type')=='trade' ? 2 : 1;

        $plat_obj = new Platform();

        $PlatformList = $plat_obj->filter($type,$games,$settlement,$confirm,config('etc.platform.platform.render_limit'),0);

        echo json_encode($PlatformList);
    }

    public function getMore(request $request){

        $games = $request->input('games')?array_sum($request->input('games')):0;

        $settlement = $request->input('settlement');

        $confirm = $request->input('confirm'); 

        $page = $request->input('page');

        $type = $request->input('type')=='trade' ? 2 : 1;

        $plat_obj = new Platform();

        $page_info = page_helper($page,config('etc.platform.platform.render_limit'),config('etc.platform.platform.limit'));    

        $PlatformList = $plat_obj->filter($type,$games,$settlement,$confirm,$page_info['limit'],$page_info['skip']);

        echo json_encode($PlatformList);
    }

    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }
}
