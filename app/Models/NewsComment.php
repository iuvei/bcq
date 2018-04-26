<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use DB;
class NewsComment extends Model
{
    protected $table = 'news_comment';

    protected $guarded = ['status','top'];

    static function getCommentList($id){

        $comments = NewsComment::where('nid',$id)->where('status',1)->whereNull('ncid')->select('id','uid','nid','top','content','created_at')->latest()->get();//获取无二级评论的一级评论
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
            $comments[$key]->son_comment = NewsComment::where('status',1)->where('ncid',$comment->id)->select('id','uid','nid','top','content','created_at')->get();
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


    public function add_comment($uid,$nid,$sid,$content){

        if (!$nid||!$uid){
            return ['code'=>0,'msg'=>'文章或用户状态错误'];
        }

        $comment = new NewsComment();

        $comment->uid = $uid;//用户id

        $comment->nid = $nid;//文章id

        if ($sid){
            $comment->ncid = $sid;//关联评论id
        }
        $comment->content = $content;

        $comment->save();

        return ['code'=>1,'msg'=>'添加评论成功'];
    }

    public function add_comment_top($id){

        $comment = NewsComment::where('id',$id)->first();

        if (!$comment){
            return ['code'=>0,'msg'=>' 评论id状态有误 '. $comment];
        }

        $comment->top = $comment->top + 1;

        $comment->save();

        return ['code'=>1,'msg'=>'new top is : '.$comment->top];
    }

    static function getRecentComments($aid,$skip,$limit,$opt = []){
        
        $comments = DB::table('news')
            ->join('news_comment','news.id','=','news_comment.nid')
/*            ->join('users','news_comment.uid','=','users.id')*/
            ->where('news_comment.uid',$aid)
            ->where('news.status',1)
            ->where('news_comment.status',1)
            ->whereNull('ncid')
            ->select('news.id as nid','news.title','news_comment.id as cid','news_comment.content','news_comment.created_at')
            ->orderBy('news_comment.created_at','desc');

        if (!empty($limit)) {
            $comments = $comments->skip($skip)->limit($limit);
        }

        $comments = $comments->get();

        foreach ($comments as $key=>$comment){

            $comments[$key]->time = Carbon::parse($comment->created_at)->diffForHumans();

            $comments[$key]->created_at = strtotime($comments[$key]->created_at);

            $comments[$key]->type = 1;
        }

        return $comments;
    }

    public function add_complaint($id){

        $comment = NewsComment::where('id',$id)->first();

        if (!$comment){
            return ['code'=>0,'msg'=>'未找到评论id '. $comment];
        }

        $comment->complaint = $comment->complaint + 1;

        $comment->save();

        return ['code'=>1,'msg'=>'new complait is : '.$comment->complaint];
    }

    
}
