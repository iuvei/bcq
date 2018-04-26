<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use Closure;
use App\Http\Controllers\CommonController as Common;
use App\Models\UserData;
use App\Models\UserDataComment;
class UserDataDetailsPageController extends Controller
{
    protected $uid;

    protected $user_data_obj;

    protected $common_obj;

    public function __construct()
    {
        $this->user_data_obj = new UserData;

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

        $adsList = AdvertisingSystem::getAds(config('etc.user_data_details.page_id'));//获取该页所有广告位广告信息

        $did = $request->input('did');

        $user_data_details = $this->user_data_obj->getDetails($did,$this->uid);

        $ip = $request->getClientIp(); 

        $this->common_obj->addView('UserData',$did,$ip);  

        $render = [
            'adList'=>$adsList,
            'user_data_details'=>$user_data_details
        ];
        echo json_encode($render);
    }

    public function addComment(Request $request){

        $did = $request->input('did');//资料id

        $fid = $request->input('fid');//关联的父评论的id

        $content = clean($request->input('content'));//关联的父评论的评论内容

        $ret = $this->common_obj->AddComment('UserDataComment',$did,$fid,$content);

        echo json_encode($ret);

    }

    public function addCommentTop(Request $request){

        $comment_id = $request->input('cid');

        $ret = $this->common_obj->AddCommentTop('UserDataComment',$comment_id);

        echo json_encode($ret);
    }

    public function getCommentList(Request $request){

        $rid = $request->input('did');

        $comment_list = UserDataComment::getCommentList($rid);

        echo json_encode($comment_list);
    }

    public function addComplaint(Request $request){

    $comment_id = $request->input('cid');

    $ret = $this->common_obj->AddComplaint('UserDataComment',$comment_id);

    echo json_encode($ret);

    }
}