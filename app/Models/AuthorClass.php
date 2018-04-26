<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorClass extends Model
{
    protected $table = 'author_class';

    public function class_news(){

        return $this->hasMany('App\Models\AuthClassNews','acid','id');

    }

    static function getClass($uid){//$type是指分类的一些详情，比如这个分类有多少文章

        $category = AuthorClass::where('status',1)->where('uid',$uid)->select('id','cname')->get();

        return $category;
    }

    static function addClass($uid,$cname){

        if (!$uid||!trim($cname)){
            return ['code'=>0,'msg'=>'confirm info correct'];
        }

        $c_obj = new AuthorClass;

        $c_obj->uid = $uid;

        $c_obj->cname = $cname;

        $c_obj->save();

        return ['code'=>1,'msg'=>'build success'];

    }

    static function deleteClass($uid,$ucid){

        $c_obj = AuthorClass::where('id',$ucid)->where('uid',$uid)->first();

        if (empty($c_obj->id)) {
            return ['code'=>0,'msg'=>'分类状态有误'];
        }

        $c_obj->status = -1;

        $c_news_obj = News::where('ucid',$ucid)->where('uid',$uid)->get();

        foreach($c_news_obj as $key=>$value){
            $c_news_obj[$key]->status = -1;
        }

        $c_news_obj->save();

        $c_obj->save();        

        return ['code'=>1,'msg'=>'delete success'];
    }

    static function restoreClass($uid,$ucid){

        $c_obj = AuthorClass::where('id',$ucid)->where('uid',$uid)->first();

        if (empty($c_obj->id)) {
            return ['code'=>0,'msg'=>'分类状态有误'];
        }

        $c_obj->status = 1;

        $c_news_obj = News::where('ucid',$ucid)->where('uid',$uid)->get();

        foreach($c_news_obj as $key=>$value){
            $c_news_obj[$key]->status = 0;
        }

        $c_news_obj->save();

        $c_obj->save();        

        return ['code'=>1,'msg'=>'restore success'];
    }

    static function renameClass($uid,$ucid,$newname){

        $class = AuthorClass::where('id',$ucid)->where('uid',$uid)->first();

        if (empty($class)){
            return ['code'=>0,'msg'=>'class not exist'];
        }

        $class->cname = $newname;

        $class->save();

        return ['code'=>1,'msg'=>'rename success'];
    }

}
