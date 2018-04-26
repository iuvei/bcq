<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Author extends Model
{
    protected $table = 'user_author';

    public function user(){

        return $this->belongsTo('App\Models\User','uid','id');

    }

    public function news(){

        return $this->hasMany('App\Models\News','uid','uid');
    }

    public function getAuthorList($skip,$limit,$opt){
        if (!$limit){
            return [];
        }
        $authorLists = Author::where('status',1)->select('id','uid','recommend','publish');
        if (isset($opt['recommend'])){//推荐资讯页面  
            $authorLists = $authorLists->orderBy('publish','desc')->orderBy('id');
        }
        if (isset($opt['recent'])){//最新作者 
            $authorLists = $authorLists->latest();
        }
        if (isset($opt['order_by_update'])){//作者专栏页面  获取全部作者 按照更新文章顺序排布
            $authorLists = $authorLists->orderBy('u_time','desc');
        }
        $authorLists = $authorLists->skip($skip)->limit($limit)->get();

        //判断是否关注了作者，-1 表示该作者就是自己 0表示没有关注该作者 1表示关注了该作者
        foreach ($authorLists as $key=>$author){
            if (isset($opt['is_attention'])&&$opt['is_attention']){
                $authorLists[$key]->is_attention = $this->is_attention($author->uid,$opt['is_attention']);
            }
            if(isset($opt['recent_news'])){//$opt['recent_news']是指获取最近的几篇文章
                $authorLists[$key]->recent_news = News::get_recent_news($author->uid,$opt['recent_news']);
            }
            $authorLists[$key]->username = name_filter($author->user->username);

            $authorLists[$key]->desc = $author->user->desc;

            $authorLists[$key]->image = $author->user->image;

            $authorLists[$key]->brief = $author->user->brief;

            $authorLists[$key]->job = $author->user->job;

            unset($author->recommend);

            unset($author->user);
        }
        return $authorLists;
    }

    public function is_attention($aid,$uid){
        $ret = User::is_attention($aid,$uid);
        return $ret;
    }

    static function GetDesc($uid){
        $author = Author::where('uid',$uid)->where('status',1)->first();
        $desc = '';
        if ($author) {
            $desc = $author->desc;
        }
        return $desc;
    }

    static function applyForAuthor($uid,$blog){

        if (!$uid){
            return ['code'=>0,'msg'=>'请先登陆账号'];
        }
        $author_obj = Author::where('uid',$uid)->first();
        if ($author_obj){
            return ['code'=>0,'msg'=>'您已经是作者'];
        }
        $new_obj = new Author;
        $new_obj->uid = $uid;
        $new_obj->blog = $blog;
        $new_obj->save();
        return ['code'=>1,'msg'=>'申请提交成功！'];
    }

    static function is_author($uid){
        $is_author = Author::where('status',1)->where('uid',$uid)->first();
        if ($is_author) {
            return true;
        }else{
            return false;
        }
    }

    public function get_components(){

        $authorLists = Author::where('status',1)
                        ->orderBy('u_time','desc')
                        ->limit(5)
                        ->select('recommend','uid')
                        ->get();

        $recommend = [];

        $index = 0;

        foreach($authorLists as $key=>$authorList){

            $recent_news = DB::table('news')->where('status',1)->where('uid',$authorList->uid)->select('id','title','view')->latest()->first();

            if (empty($recent_news)) {
                continue;
            }

            $recommend[$index]['recommend'] = $authorList->recommend;

            $recommend[$index]['news'] = $recent_news;

            $recommend[$index]['view'] = $recent_news->view;

            $recommend[$index]['uid'] = $authorList->uid;

            $recommend[$index]['username'] = name_filter($authorList->user->username);

            $recommend[$index]['image'] = $authorList->user->image;

            $recommend[$index]['desc'] = $authorList->user->desc;
            
            $index++;
        }

        $recommend = collect($recommend);

        $recommend = $recommend?$recommend->sortByDesc('view')->sortByDesc('recommend')->values()->all():$recommend;        

        return $recommend;
    }

}