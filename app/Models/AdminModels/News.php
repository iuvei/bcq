<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class News extends Model
{
    protected $table = 'news';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope("avaiable",function (Builder $query){
            $query->whereIn('news.status',[0,1,-1]);
        });
    }

    public function special(){

        return $this->belongsToMany('App\Models\AdminModels\Special','special_news','nid','sid');

    }

    public function show(){

        return $this->belongsToMany('App\Models\AdminModels\Show','show_news','nid','sid');

    }

    public function Slide()
    {
        return $this->morphMany('App\Models\AdminModels\Slide', 'Slide');
    }

    public function Fall()
    {
        return $this->morphMany('App\Models\AdminModels\Fall', 'Fall','model','cid');
    }

    public function user(){

        return $this->belongsTo('App\Models\AdminModels\User','uid','id');

    }

    public function category(){

        return $this->belongsTo('App\Models\AdminModels\NewsCategory','cid','id');

    }

    static function getNews($skip,$limit,$flag,$orOpt=array(),$betweenOpt=array()){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = News::whereIn('status',[0,1])->orderBy('id', 'desc');
        if (!empty($betweenOpt)){
            foreach ($betweenOpt as $k => $v){
                $query = $query->whereBetween($k,$v);
            }
        }
        if (!empty($orOpt)){
            $query = $query->where(function ($query) use($orOpt){
                foreach ($orOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        }

        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }
        $obj->load(['user','category']);

        return $obj;
    }

    static function getNewsCount(){

        $count = News::whereIn('status',[0,1])->count();

        return $count;
    }

    static function getNotSpecial($skip,$limit,$flag,$orOpt=array(),$betweenOpt=array(),$sid){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = News::whereDoesntHave('special', function ($query) use($sid) {
            $query->where('special.id', $sid)->whereIn('special_news.status',[0,1]);
        });

        if (!empty($betweenOpt)){
            foreach ($betweenOpt as $k => $v){
                $query = $query->whereBetween($k,$v);
            }
        }
        if (!empty($orOpt)){
            $query = $query->where(function ($query) use($orOpt){
                foreach ($orOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        }

        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }

        return $obj;

    }

    static function getNotSpecialCount($sid){

        $count = News::whereDoesntHave('special', function ($query) use($sid) {
            $query->where('special.id', $sid)->whereIn('special_news.status',[0,1]);
        })->count();

        return $count;
    }

    static function getNotShow($skip,$limit,$flag,$orOpt=array(),$betweenOpt=array(),$sid){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $query = News::whereDoesntHave('show', function ($query) use($sid) {
            $query->where('show.id', $sid)->whereIn('show_news.status',[0,1]);
        });

        if (!empty($betweenOpt)){
            foreach ($betweenOpt as $k => $v){
                $query = $query->whereBetween($k,$v);
            }
        }
        if (!empty($orOpt)){
            $query = $query->where(function ($query) use($orOpt){
                foreach ($orOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        }

        if ($flag){
            $obj = $query->get();
        }else{
            $obj = $query->skip($skip)->limit($limit)->get();
        }

        return $obj;

    }

    static function getNotShowCount($sid){

        $count = News::whereDoesntHave('show', function ($query) use($sid) {
            $query->where('show.id', $sid)->whereIn('show_news.status',[0,1]);
        })->count();

        return $count;
    }

    static function getAuthorNewsCount($uid){

        $count = News::where('uid', $uid)->count();

        return $count;
    }

    /**
     * 模拟post进行url请求
     * @param string $url
     * @param array $post_data
     */
    static function request_post($url = '', $post_data = array()) {
        if (empty($url) || empty($post_data)) {
            return false;
        }

        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $postUrl = $url;
        $curlPost = $post_data;

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        return $data;
    }

}
