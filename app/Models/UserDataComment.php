<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use DB;
class UserDataComment extends Model
{
    //
    protected $table = 'data_comment';

/*    public function commentable(){

        return $this->morphMany('App\Models\UserComment','commentable');
    }*/    

    static function getCommentList($id){

        $comments = UserDataComment::where('did',$id)->where('status',1)->whereNull('dcid')->select('id','uid','did','top','content','created_at')->latest()->get();//获取无二级评论的一级评论
        foreach ($comments as $key=>$comment){
            //获取子集评论列表
            $comments[$key]->comment_time = $comment->created_at->diffForHumans();
            $comments[$key]->user = User::where('id',$comment->uid)->select('id','username','image','desc')->first();
            $comments[$key]->user->username = name_filter($comments[$key]->user->username);
            $comments[$key]->son_comment = UserDataComment::where('status',1)->where('dcid',$comment->id)->select('id','uid','did','top','content','created_at')->get();
            $comments[$key]->user->author_info;
            foreach ($comments[$key]->son_comment as $key2=>$son_comment){
                $comments[$key]->son_comment[$key2]->comment_time = $comment->created_at->diffForHumans();
                $comments[$key]->son_comment[$key2]->user = User::where('id',$son_comment->uid)->select('id','username','image','desc')->first();
                $comments[$key]->son_comment[$key2]->user->username = name_filter($comments[$key]->son_comment[$key2]->user->username);
                $comments[$key]->son_comment[$key2]->user->author_info; 
            }
        }

        return $comments;
    }

    public function add_comment($uid,$did,$fcid,$content){

        $comment = new UserDataComment();

        if (!$did||!$uid){
            return ['code'=>0,'msg'=>'数据或用户状态有误'];
        }

        $comment->uid = $uid;//用户id

        $comment->did = $did;//资料id

        if ($fcid){

            $comment->dcid = $fcid;//关联评论id

        }
        $comment->content = $content;

        $comment->save();

        return ['code'=>1,'msg'=>'添加成功'];
    }

    public function add_comment_top($id){

        $comment = UserDataComment::where('id',$id)->first();

        if (!$comment){
            return ['code'=>0,'msg'=>'评论id有误：'. $comment];
        }

        $comment->top = $comment->top + 1;

        $comment->save();

        return ['code'=>1,'msg'=>'new top is : '.$comment->top];
    }

    public function add_complaint($id){

        $comment = UserDataComment::where('id',$id)->first();

        if (!$comment){
            return ['code'=>0,'msg'=>'未找到评论id '. $comment];
        }

        $comment->complaint = $comment->complaint + 1;

        $comment->save();

        return ['code'=>1,'msg'=>'new complait is : '.$comment->complaint];
    }

    static function getRecentComments($aid,$skip,$limit,$opt = []){
        
        $comments = DB::table('data')
            ->join('data_comment','data.id','=','data_comment.did')
/*            ->join('users','data_comment.uid','=','users.id')
            ->where('data.uid',$aid)*/
            ->where('data.status',1)
            ->where('data_comment.uid',$aid)
            ->where('data_comment.status',1)
            ->select('data.id as nid','data.title','data_comment.id as cid','data_comment.content','data_comment.created_at')
            ->orderBy('data_comment.created_at','desc');

        if (!empty($limit)) {
            $comments = $comments->skip($skip)->limit($limit);
        }

        $comments = $comments->get();

        foreach ($comments as $key=>$comment){

            $comments[$key]->time = Carbon::parse($comment->created_at)->diffForHumans();

            $comments[$key]->created_at = strtotime($comments[$key]->created_at);

            $comments[$key]->type = 4;
        }

        return $comments;
    }
}
