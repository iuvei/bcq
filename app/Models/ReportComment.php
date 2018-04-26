<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use DB;
class ReportComment extends Model
{
    protected $table='report_comment';

/*    public function commentable(){

        return $this->morphMany('App\Models\UserComment','commentable');
    }*/    

    static function getCommentList($rid){

        $comments = ReportComment::where('rid',$rid)->where('status',1)->whereNull('rcid')->select('id','uid','rid','top','content','created_at')->latest()->get();//获取无二级评论的一级评论
        foreach ($comments as $key=>$comment){
            $comments[$key]->comment_time = $comment->created_at->diffForHumans();
            //获取子集评论列表
            $comments[$key]->user = User::where('id',$comment->uid)->select('id','username','image','desc')->first();
            $comments[$key]->user->username = name_filter($comments[$key]->user->username);
            $comments[$key]->son_comment = ReportComment::where('status',1)->where('rcid',$comment->id)->select('id','uid','rid','top','content','created_at')->get();
            $comments[$key]->user->author_info;
            foreach ($comments[$key]->son_comment as $key2=>$son_comment){
                $comments[$key]->son_comment[$key2]->comment_time = $son_comment->created_at->diffForHumans();
                $comments[$key]->son_comment[$key2]->user = User::where('id',$son_comment->uid)->select('id','username','desc')->first();
                $comments[$key]->son_comment[$key2]->user->author_info;                
                $comments[$key]->son_comment[$key2]->user->username = name_filter($comments[$key]->son_comment[$key2]->user->username);
            }
        }
        return $comments;
    }

    public function add_comment($uid,$rid,$fcid,$content){

        $comment = new ReportComment();

        $comment->uid = $uid;//用户id

        if (!$rid||!$uid){
            return ['code'=>0,'msg'=>'数据或用户状态有误'];
        }

        $comment->rid = $rid;//资料id

        if ($fcid){

            $comment->rcid = $fcid;//关联评论id

        }
        $comment->content = $content;

        $comment->save();

        
        
        return ['code'=>1,'msg'=>'评论成功'];
    }

    public function add_comment_top($id){

        $comment = ReportComment::where('id',$id)->first();

        if (!$comment){
            return ['code'=>0,'msg'=>'未找到评论id '. $comment];
        }

        $comment->top = $comment->top + 1;

        $comment->save();

        return ['code'=>1,'msg'=>'new top is : '.$comment->top];
    }


    public function add_complaint($id){

        $comment = ReportComment::where('id',$id)->first();

        if (!$comment){
            return ['code'=>0,'msg'=>'未找到评论id '. $comment];
        }

        $comment->complaint = $comment->complaint + 1;

        $comment->save();

        return ['code'=>1,'msg'=>'new complait is : '.$comment->complaint];
    }

    static function getRecentComments($aid,$skip,$limit,$opt = []){
        
        $comments = DB::table('report')
            ->join('report_comment','report.id','=','report_comment.rid')
/*            ->join('users','report_comment.uid','=','users.id')*/
            ->where('report_comment.uid',$aid)
            ->where('report.status',1)
            ->where('report_comment.status',1)
            ->select('report.id as nid','report.title','report_comment.id as cid','report_comment.content','report_comment.created_at')
            ->orderBy('report_comment.created_at','desc');

        if (!empty($limit)) {
            $comments = $comments->skip($skip)->limit($limit);
        }

        $comments = $comments->get();

        foreach ($comments as $key=>$comment){

            $comments[$key]->time = Carbon::parse($comment->created_at)->diffForHumans();

            $comments[$key]->created_at = strtotime($comments[$key]->created_at);

            $comments[$key]->type = 3;
        }

        return $comments;
    }

}
