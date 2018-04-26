<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use App\Models\News;
use AdvertisingSystem;
use DisplaySystem;
use App\Models\NewsComment;
use App\Http\Controllers\CommonController as Common;
class NewsDetailsPageController extends Controller
{
    protected $uid = null;

    protected $news_obj;

    protected $common_obj;

    public function __construct(Request $request)
    {
        $this->news_obj = new News();

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

        $nid = $request->input('nid');

        $adsList = AdvertisingSystem::getAds(config('etc.news_details.page_id'));//获取该页所有广告位广告信息

        $newsDetails = $this->news_obj->getDetails($nid,$this->uid,config('etc.news_details.render_limit.latest_news'));

        $ip = $request->getClientIp();  

        $this->common_obj->addView('News',$nid,$ip);


        if (!$newsDetails) {
            echo json_encode(['newsDetails'=>'']);
            die;
        }

        $relateNews = $this->news_obj->getRelateNews($nid,config('etc.news_details.render_limit.keyword_news'),config('etc.news_details.render_limit.new_news'));

        $render = [
            'ad_list'=>$adsList,
            'newsDetails'=>$newsDetails,
            'relateNews'=>$relateNews
        ];
        echo json_encode($render);
    }

    public function addAttention(Request $request){//添加关注

        $aid = $request->input('aid');

        $ret = $this->common_obj->Attention($aid);

        echo json_encode( $ret);
    }

    public function addCollection(Request $request){//添加收藏

        $nid = $request->input('nid');

        $model = $request->input('model');

        $ret = $this->common_obj->Collection($model,$nid);

        echo json_encode( $ret);
    }

    public function addComment(Request $request){

        $id = $request->input('nid');//文章id

        $fid = $request->input('fid');//关联的父评论的id

        $content = clean($request->input('content'));//关联的父评论的评论内容

        $ret = $this->common_obj->AddComment('NewsComment',$id,$fid,$content);

        echo json_encode($ret);

    }

    public function addCommentTop(Request $request){

        $comment_id = $request->input('cid');

        $ret = $this->common_obj->AddCommentTop('NewsComment',$comment_id);

        echo json_encode($ret);
    }

    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

    public function getCommentList(Request $request){

        $nid = $request->input('nid');

        $comment_list = NewsComment::getCommentList($nid);

        echo json_encode($comment_list);

    }

    public function addTop(Request $request){

        $nid = $request->input('nid');

        $this->news_obj->addTop($nid);

    }

    public function addComplaint(Request $request){

        $comment_id = $request->input('cid');

        $ret = $this->common_obj->AddComplaint('NewsComment',$comment_id);

        echo json_encode($ret);

    }
}