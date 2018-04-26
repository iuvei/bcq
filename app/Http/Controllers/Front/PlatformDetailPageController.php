<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use App\Models\Platform;
use App\Http\Controllers\CommonController as Common;
class PlatformDetailPageController extends Controller   //已认证平台详情页
{
    private $uid;

    private $platform_obj;

    protected $common_obj;

    public function __construct(Request $request)
    {

        $this->platform_obj = new Platform();

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

        $platform_id = $request->input('bid');

        $ip = $request->getClientIp();

        $this->common_obj->addView('Platform',$platform_id,$ip);//增加一次浏览量

        $platform_info = $this->platform_obj->platformConfirm($platform_id,$this->uid);

        $proxyList = $this->platform_obj->getPlatformList(0,config('etc.platform_detail.command_platform.limit'),['hot'=>1,'type'=>1,'except_id'=>$platform_id]);//hot表示是推荐的 type = 1表示是供应

        $tradeList = $this->platform_obj->getPlatformList(0,config('etc.platform_detail.command_platform.limit'),['hot'=>1,'type'=>2,'except_id'=>$platform_id]);//hot表示是推荐的 type = 1表示是供应

        $render = [
            'platform_info'=>$platform_info,
            'proxyList'=>$proxyList,
            'tradeList'=>$tradeList,
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

        $platform_id = $request->input('pid');//platform的主键id

        $add_ret = $this->platform_obj->addTop($platform_id);

        echo json_encode($add_ret);
    }

    public function addCollection(Request $request){//添加收藏

        if (empty($this->uid)){
            echo json_encode(['code'=>0,'msg'=>'请先登陆账号']);
            die;
        }
        $platform_id = $request->input('pid');//platform的主键id

        $add_ret = $this->platform_obj->add_collection($platform_id,$this->uid);

        echo json_encode($add_ret);

    }

    public function confirm($pid,$plate_id){

        $info = $this->platform_obj->platformConfirm($pid,$this->uid);

        $plate_id = intval($plate_id);

        $plate = config("base.plate.$plate_id");

        if($plate && intval($info->plate) & $plate_id){

            return view('Front.plate.plate',compact('info','plate'));

        }else{

            return Redirect("/trade/PlatformDetail/$pid");

        }

    }
}
