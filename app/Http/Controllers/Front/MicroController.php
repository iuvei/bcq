<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use App\Models\User;
use App\Http\Controllers\CommonController as Common;
class MicroController extends Controller
{
    //微动态
    protected $user; 

    protected $common_obj;

    public function __construct()
    {
        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

	        $this->common_obj = new Common();

            if ($user_info['code'] == 1){

                $this->user = $user_info['user'];

            }

            return $next($request);

        });
    }

    public function NewMicro(Request $request){

    	if (empty($this->user)) {

            echo json_encode(['code'=>0,'msg'=>'请先登录']);

            die;            
    	}

    	$game_level = config('base.game_level');

    	$micro_obj = get_model_obj('Micro');

        $fall_obj = get_model_obj('Falls');

    	$micro = $request->input('micro');

    	if (mb_strlen($micro['content'])>500||mb_strlen($micro['content'])<10) {
    		
    		echo json_encode(['code'=>0,'msg'=>'字数请保持在10-500字之间']);

    		die;

    	}

        if ($this->user->level_id<10) {

            $count = $micro_obj->GetDayPublish($this->user->id);

            if ($count>=2) {

                echo json_encode(['code'=>0,'msg'=>'您好，您一天只能发送两条微动态']);

                die;
            }
        }

    	if ($this->user->level_id == $game_level) {
    		
    		$micro_obj->utype = '1';

    	}

    	$micro_obj->uid = $this->user->id;

    	$micro_obj->content = clean($micro['content']);

    	$micro_obj->image = json_encode($micro['img']);

        $micro_obj->status = 1;

    	$micro_obj->save();

        $title = mb_substr(strip_tags($micro_obj->content),0,100);

        $fall_obj->InsetToFalls('Micro',$micro_obj->id,$micro_obj->uid,$title);

    	echo json_encode(['code'=>1,'msg'=>'微动态发布成功']);

    }

    public function GetMicroDetail(Request $request){

    	$id = $request->input('id');

    	if (!$id) {

    		echo json_encode(['code'=>0,'msg'=>'微动态状态有误']);

    		die;
    	}

    	$micro_obj = get_model_obj('Micro');

    	$comment_obj = get_model_obj('MicroComment');

    	$detail = $micro_obj->MicroDetail($id);

    	if (empty($detail)) {

	    	echo json_encode(['code'=>0,'msg'=>'动态内容不存在']);

	    	die;
    	}

        $ip = $request->getClientIp();  

        $this->common_obj->addView('Micro',$id,$ip);

    	$detail->image = json_decode($detail->image,true);

        if (isset($this->user->id)) {
            $detail->is_attention = User::is_attention($detail->user->id,$this->user->id);            
        }else{
            $detail->is_attention = 0;
        }

        $detail->comment_list = $comment_obj->getCommentList($detail->id);

        if (!empty($this->user)) {
            $detail->avatar = $this->user->image;
        }

    	echo json_encode(['code'=>1,'msg'=>$detail]);

    	die;
    }

    public function addComment(Request $request){

        $id = $request->input('mid');//文章id

        $fid = $request->input('fid');//关联的父评论的id

        $content = clean($request->input('content'));//关联的父评论的评论内容

        $ret = $this->common_obj->AddComment('MicroComment',$id,$fid,$content);

        echo json_encode($ret);

    }

    public function addCommentTop(Request $request){

        $comment_id = $request->input('cid');

        $ret = $this->common_obj->AddCommentTop('MicroComment',$comment_id);

        echo json_encode($ret);
    }

    public function addComplaint(Request $request){

        $comment_id = $request->input('cid');

        $ret = $this->common_obj->AddComplaint('MicroComment',$comment_id);

        echo json_encode($ret);

    }      

    public function getCommentList(Request $request){

        $mid = $request->input('mid');

    	$comment_obj = get_model_obj('MicroComment');

        $comment_list = $comment_obj->getCommentList($mid);

        echo json_encode($comment_list);

    }    


    public function addTop(Request $request){


    }

    public function GetRelateMicro(Request $request){

        $id = $request->input('id');

        $micro_obj = get_model_obj('Micro');

        $micro = $micro_obj->where('id',$id)->first();

        if (empty($micro)) {
            
            return $micro;

        }

        $uid = $micro->uid;

        $relate = $micro_obj->GetRelateMicro($uid,$id);

        echo json_encode($relate);

    }

    public function GetRecommendMicro(Request $request){

        $page = $request->input('page');

        $limit = 5;

        $skip = $page*$limit;
        
        $micro_obj = get_model_obj('Micro');

        $recommand = $micro_obj->GetRecommendMicro($limit,$skip);

        foreach ($recommand as $key => $value) {
            if (isset($this->user->id)) {
                $recommand[$key]->is_attention = User::is_attention($value->uid,$this->user->id);            
            }else{
                $recommand[$key]->is_attention = 0;
            }
        }

        echo json_encode($recommand);

    }   

}