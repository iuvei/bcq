<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use Closure;
use App\Http\Controllers\CommonController as Common;
use App\Models\Report;
use App\Models\ReportComment;
class ReportDetailsPageController extends Controller
{
    protected $uid;

    protected $report_obj;

    public function __construct()
    {
        $this->report_obj = new Report;

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

        $adsList = AdvertisingSystem::getAds(config('etc.report_details.page_id'));//获取该页所有广告位广告信息

        $rid = $request->input('rid');

        $ip = $request->getClientIp();        

        $this->common_obj->addView('Report',$rid,$ip);        

        $report_details = $this->report_obj->getDetails($rid,$this->uid);

        $report_more = $this->report_obj->getMoreReport($rid);

        $render = [
            'adList'=>$adsList,
            'reportDetails'=>$report_details,
            'report_more'=>$report_more
        ];
        echo json_encode($render);
    }


    public function getCommentList(Request $request){

        $rid = $request->input('rid');

        $comment_list = ReportComment::getCommentList($rid);

        echo json_encode($comment_list);
    }

    public function addComment(Request $request){

        $rid = $request->input('rid');//资料id

        $fid = $request->input('fid');//关联的父评论的id

        $content = $request->input('content');//关联的父评论的评论内容

        $ret = $this->common_obj->AddComment('ReportComment',$rid,$fid,$content);

        echo json_encode($ret);

    }

    public function addCommentTop(Request $request){

        $comment_id = $request->input('cid');

        $ret = $this->common_obj->AddCommentTop('ReportComment',$comment_id);

        echo json_encode($ret);
    }

    public function addComplaint(Request $request){

        $comment_id = $request->input('cid');

        $ret = $this->common_obj->AddComplaint('ReportComment',$comment_id);

        echo json_encode($ret);

    }
}