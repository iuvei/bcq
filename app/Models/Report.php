<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Report extends Model
{
    protected $table = 'report';

    public function fileinfo(){
        return $this->hasOne('App\Models\File','id','file');
    }

    public function Slide()
    {
        return $this->morphMany('App\Models\Slide', 'Slide');
    }

    public function getReportList($skip,$limit,$opt){

        if (empty($limit)){

            return [];
        }

        $reportList = Report::where('status',1)->skip($skip)->limit($limit) ->orderBy('created_at', 'desc');

        $reportList = $reportList->select('id','title','brief','file','price','suffix','updated_at');

        $reportList = $reportList->get();

        foreach ($reportList as $key=>$report){

            if (isset($opt['is_collected'])){

                $reportList[$key]->is_collected = $this->is_collected($report->id,$opt['is_collected']);
            }
        }
        return $reportList;
    }

    public function getView($id){//获取浏览量

        $obj = Report::find($id);

        return $obj->f_view;
    }

    public function getComment($id){//获取评论数量

        $comment = DB::table('report_comment')->where('rid',$id)->whereNull('rcid')->where('status',1)->count();

        return $comment;
    }

    public function getCollection($id){//获取收藏数量

        $collection = DB::table('report_collection')->where('rid',$id)->where('status',1)->count();

        return $collection;
    }

    public function is_collected($rid,$uid){

        $is_collected = DB::table('report_collection')->where('uid',$uid)->where('rid',$rid)->where('status',1)->count();

        return $is_collected;
    }

    public function add_collection($rid,$uid){

        $collection = DB::table('report_collection')->where('uid',$uid)->where('rid',$rid)->first();

        if ($collection){
            if ($collection->status){
                $collection = DB::table('report_collection')->where('uid',$uid)->where('rid',$rid)->update(['status'=>0]);
            }else{
                $collection = DB::table('report_collection')->where('uid',$uid)->where('rid',$rid)->update(['status'=>1]);
            }
        }else{
            $collection = DB::table('report_collection')->insert(['uid'=>$uid,'rid'=>$rid,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        }

        if (!$collection){
            return ['code'=>0,'msg'=>'update status fail'];
        }

        return ['code'=>1,'msg'=>'update status success'];
    }

    public function getDetails($rid,$uid){//参数uid是指当前登录用户
        //数据库查的uid是指发布资料的用户
        $report = Report::where('status',1)->where('id',$rid)->select('id','title','brief','content','file','f_view','price','created_at')->first();
        if (!$report){
            return [];
        }
        $report->view = $report->f_view;
        $report->content = htmlspecialchars_decode(html_entity_decode($report->content));
        $report->down = $report->fileinfo->down*10;//获取下载数量
        unset($report->fileinfo);
        if ($uid){
            $report->is_collected = $this->is_collected($rid,$uid);//如何用户登录，查看是否收藏该资料
        }
        $report->comment = $this->getComment($report->id);
        $report->collection = $this->getCollection($report->id);        
        $report->comment_list = ReportComment::getCommentList($report->id);
        return $report;
    }

    public function getMoreReport($exclude = ''){//获取除了这个数据报告的其他数据报告
        
        $report = Report::where('status',1);

        if ($exclude) {

            $report = $report->where('id','<',$exclude);

        }

        $report = $report->select('id','title')->limit(5)->orderBy('created_at','desc')->get();

        return $report;
    }

    public function addView($id){

        $report = Report::where('id',$id)->first();

        $f_view = $report->f_view;

        $time = $report->updated_at->timestamp;     

        $time_sub = (time()-$time)/3600;

        $conf = config('base.view_config.report');

        $f_view = view_rand($f_view,$time_sub,$conf);

        DB::table('report')->where('id',$id)->increment('view');

        DB::table('report')->where('id',$id)->increment('f_view',$f_view);                

    } 

    public function AssembleData($id){

        $data = Report::where('id',$id)

                ->where('status',1)

                ->select('id','title','f_view','updated_at')

                ->first();
        
        if (empty($data)) {

            return false;
        }
        
        $user = User::find(1);

        $data->user_name = $user->username;

        $data->user_image = $user->image;

        $data->uid = $user->id;
        
        $data->time = isset($data->updated_at)?$data->updated_at->diffForHumans():'';

        $data->comment = $this->getComment($id);

        $data->collection = $this->getCollection($id);

        return $data;

    }   
}

