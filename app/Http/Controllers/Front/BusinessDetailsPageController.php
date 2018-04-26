<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use DisplaySystem;
use App\Models\Business;
use App\Http\Controllers\CommonController as Common;
class BusinessDetailsPageController extends Controller   //已认证平台详情页
{
    private $uid;
    
    private $business_obj;

    protected $common_obj;
    
    public function __construct(Request $request)
    {

        $this->business_obj = new Business();

        $this->common_obj = new Common();
        
        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;

            }
            return $next($request);
        });
    }

    public function render(Request $request){

        $business_id = $request->input('bid');

        $ip = $request->getClientIp();

        $this->common_obj->addView('Business',$business_id,$ip);//增加一次浏览量

        $business_info = $this->business_obj->businessConfirm($business_id,$this->uid);

        $supplyList = $this->business_obj->getBusinessList(0,config('etc.business_detail.command_business.limit'),['hot'=>1,'type'=>1,'except_id'=>$business_id]);//hot表示是推荐的 type = 1表示是供应

        $buyList = $this->business_obj->getBusinessList(0,config('etc.business_detail.command_business.limit'),['hot'=>1,'type'=>2,'except_id'=>$business_id]);//hot表示是推荐的 type = 1表示是供应

        //种类分类
        $catList = $this->getList('Bcategory',0,10000,[])->groupBy('fid');
        //游戏接口服务
        $gameList = $this->getList('GameStoreCategory',0,6,['no_detail'=>1]);

        $render = [
            'business_info'=>$business_info,
            'supplyList'=>$supplyList,
            'buyList'=>$buyList,
            'catList'=>$catList,
            'gameList'=>$gameList,
            'plateList'=>config('base.plate'),
            'isLogin'=>$this->uid?1:0,
        ];

        echo json_encode($render);
    }

    public function addTop(Request $request){//点赞

        if (empty($this->uid)){
            echo json_encode(['code'=>0,'请先登陆账号']);
            die;
        }

        $business_id = $request->input('pid');//business的主键id

        $add_ret = $this->business_obj->addTop($business_id);

        echo json_encode($add_ret);
    }

    public function addCollection(Request $request){//添加收藏

        if (empty($this->uid)){
            echo json_encode(['code'=>0,'msg'=>'请先登陆账号']);
            die;
        }
        $business_id = $request->input('pid');//business的主键id

        $add_ret = $this->business_obj->add_collection($business_id,$this->uid);

        echo json_encode($add_ret);

    }

    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

    public function confirm($bid,$plate_id){

        $info = $this->business_obj->businessConfirm($bid,$this->uid);

        $plate_id = intval($plate_id);

        $plate = config("base.plate.$plate_id");

        if($plate && intval($info->plate) & $plate_id){

            return view('Front.plate.plate',compact('info','plate'));

        }else{

            return Redirect("/trade/BusinessDetail/$bid");

        }

    }
}
