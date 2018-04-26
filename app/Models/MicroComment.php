<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
class MicroComment extends Model
{
    //
    protected $table = 'micro_comment';

    public function getCommentList($id){

        $comments = MicroComment::where('mid',$id)->where('status',1)->whereNull('mcid')->select('id','uid','mid','top','content','created_at')->latest()->get();//获取无二级评论的一级评论
        foreach ($comments as $key=>$comment){
            $comments[$key]->comment_time = $comment->created_at->diffForHumans();
            $comments[$key]->user = User::where('id',$comment->uid)->select('id','username','image','desc')->first();//获取评论用户信息
            if(!$comments[$key]->user){
                unset($comments[$key]);
                continue;
            }
            $comments[$key]->user->username = name_filter($comments[$key]->user->username);

            $comments[$key]->user->author_info;
            //获取子集评论列表
            $comments[$key]->son_comment = MicroComment::where('status',1)->where('mcid',$comment->id)->select('id','uid','mid','top','content','created_at')->get();
            foreach ($comments[$key]->son_comment as $key2=>$son_comment){
                $comments[$key]->son_comment[$key2]->user = User::where('id',$son_comment->uid)->select('id','username','image','desc')->first();
                $comments[$key]->son_comment[$key2]->comment_time = $son_comment->created_at->diffForHumans();
                if(!$comments[$key]->son_comment[$key2]->user){
                    unset($comments[$key]->son_comment[$key2]);
                    continue;
                }
                $comments[$key]->son_comment[$key2]->user->author_info;
                $comments[$key]->son_comment[$key2]->user->username = name_filter($comments[$key]->son_comment[$key2]->user->username);
            }
        }
        return $comments;
    }


    public function add_comment($uid,$mid,$sid,$content){

        if (!$mid||!$uid){
            return ['code'=>0,'msg'=>'微状态或用户状态错误'];
        }

        $comment = new MicroComment();

        $comment->uid = $uid;//用户id

        $comment->mid = $mid;//文章id

        if ($sid){
            $comment->mcid = $sid;//关联评论id
        }
        $comment->content = $content;

        $comment->save();

        return ['code'=>1,'msg'=>'添加评论成功'];
    }

    public function add_comment_top($id){

        $comment = MicroComment::where('id',$id)->first();

        if (!$comment){
            return ['code'=>0,'msg'=>' 评论id状态有误 '. $comment];
        }

        $comment->top = $comment->top + 1;

        $comment->save();

        return ['code'=>1,'msg'=>'new top is : '.$comment->top];
    }


    static function getRecentComments($aid,$skip,$limit,$opt = []){
        
        $comments = DB::table('micro')
            ->join('micro_comment','micro.id','=','micro_comment.mid')
            ->where('micro_comment.uid',$aid)
            ->where('micro.status',1)
            ->where('micro_comment.status',1)
            ->whereNull('mcid')
            ->select('micro.id as nid','micro.content as title','micro_comment.id as cid','micro_comment.content','micro_comment.created_at')
            ->orderBy('micro_comment.created_at','desc');

        if (!empty($limit)) {
            $comments = $comments->skip($skip)->limit($limit);
        }

        $comments = $comments->get();

        foreach ($comments as $key=>$comment){

            $comments[$key]->time = Carbon::parse($comment->created_at)->diffForHumans();

            $comments[$key]->created_at = strtotime($comments[$key]->created_at);

            $comments[$key]->type = 5;
        }

        return $comments;
    }


}
