<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use Closure;
class UserDataPageController extends Controller
{

    protected $uid;

    protected $userDataOpt;

    public function __construct(Request $request){

        $this->userDataOpt = ['field'=>['View','Comment'],'file_info'=>1];

        //当用户登录时会有关注状态，针对某篇文章会有是否收藏等状态

        $this->middleware(function ($request,Closure $next){

            $user_info = get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;
                //登陆后才显示关注状态
                $this->userDataOpt = ['is_collected'=>$this->uid,'field'=>['View','Comment'],'file_info'=>1];

            }
                return $next($request);
        });
    }

    public function render(){

        $adsList = AdvertisingSystem::getAds(config('etc.user_data.page_id'));//获取该页所有广告位广告信息

        $userDataList =  $this->getList('UserData',0,config('etc.user_data.user_data.render_limit'),$this->userDataOpt);

        $render = [
            'adList'=>$adsList,
            'userDataList'=>$userDataList
        ];
        echo json_encode($render);
    }

    public function getUserdataList(Request $request){

        $page = $request->input('page');

        $type = $request->input('type');

        $this->userDataOpt['type'] = $type;

        $page_info = page_helper($page,config('etc.user_data.user_data.render_limit'),config('etc.user_data.user_data.limit'));

        $userDataList = $this->getList('UserData',$page_info['skip'],$page_info['limit'],$this->userDataOpt);

        echo json_encode($userDataList);        
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}
