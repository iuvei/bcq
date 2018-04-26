<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use App\Models\Business;
class BusinessPageController extends Controller
{
    //代理招商页面
    public function render(){

        $adsList = AdvertisingSystem::getAds(config('etc.business.page_id'));//获取该页所有广告位广告信息
        //供应信息
        $supplyList = $this->getList('Business',0,config('etc.business.business.render_limit'),['type'=>1]);
        //求购信息
        $buyList = $this->getList('Business',0,config('etc.business.business.render_limit'),['type'=>2]);
        //种类分类
        $catList = $this->getList('Bcategory',0,10000,[])->groupBy('fid');

        //游戏接口服务
        $gameList = $this->getList('GameStoreCategory',0,6,['no_detail'=>1]);

        $render = [
            'adsList'=>$adsList,
            'supplyList'=>$supplyList,
            'buyList'=>$buyList,
            'catList'=>$catList,
            'gameList'=>$gameList
        ];

        echo json_encode($render);
    }

    public function filter(Request $request){

        $bid = $request->input('bid');

        $confirm = $request->input('confirm'); 

        $type = $request->input('type')=='supply' ? 1 : 2;

        $plat_obj = new Business();

        $PlatformList = $plat_obj->filter($type,$bid,$confirm,config('etc.business.business.render_limit'),0);

        echo json_encode($PlatformList);
    }

    public function getMore(request $request){

        $bid = $request->input('bid');

        $confirm = $request->input('confirm'); 

        $type = $request->input('type')=='supply' ? 1 : 2;

        $page = $request->input('page');

        $plat_obj = new Business();
   
        $page_info = page_helper($page,config('etc.business.business.render_limit'),config('etc.business.business.limit'));    

        $PlatformList = $plat_obj->filter($type,$bid,$confirm,$page_info['limit'],$page_info['skip']);

        echo json_encode($PlatformList);
    }

    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }
}
