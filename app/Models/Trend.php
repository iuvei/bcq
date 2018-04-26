<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Trend extends Model//产品表
{
    //
    public function user(){
        return $this->belongsTo('App\Models\User','uid','id');
    }

    public function getTrendList($skip,$limit,$opt){

        if (!$limit){
            return [];
        }

        $trendList = Trend::where('status',1);

        if (isset($opt['uid'])){
            $trendList = $trendList->where('uid',$opt['uid']);
        }

        $trendList = $trendList->select('id','title','content','product_url','uid','type','created_at')->skip($skip)->limit($limit)->latest()->get();

        foreach ($trendList as $key=>$trend){

            $type = [];

            foreach([pow(2,0),pow(2,1),pow(2,2)] as $pow){

                if ($pow&$trendList[$key]->type) {
                    $type[] = $pow;
                }
            }

            $trendList[$key]->type = $type;            

            $trendList[$key]->date = $trend->created_at->toDateString();

            $trendList[$key]->month = $trend->created_at->month;

            $trendList[$key]->day = $trend->created_at->day;

            $trendList[$key]->view = $this->getView($trend->id);

            $trendList[$key]->username = name_filter($trend->user->username);

            unset($trendList[$key]->user);

        }

        return $trendList;
    }

    public function getCount(){

        $count = Trend::where('status',1)->select('type')->get();

        return $count;  

    }

    public function getView($id){//获取浏览量

        $obj = Trend::find($id);

        return $obj->f_view;
    }

    public function getComment($id){//获取评论数量
        $comment = DB::table('trends_comment')->where('tid',$id)->where('status',1)->count();
        return $comment;
    }

    public function getCollection($id){//获取收藏数量

        $collection = DB::table('trends_collection')->where('tid',$id)->where('status',1)->count();;

        return $collection;
    }

    public function addTrend(array $params){

        $trend = new Trend();

        foreach ($params as $key=>$param){
            if (!strlen($param)){
                $msg = $key.' must not be empty';
                return ['code'=>0,'msg'=>$msg];
            }
            $trend->$key = $param;
        }

        $trend->status = 0;

        $trend->save();

        $id = $trend->id;

        $trend = $trend->latest()->first();

        $trend->type = json_decode($trend->type,true);            

        $trend->date = $trend->created_at->toDateString();

        $trend->month = $trend->created_at->month;

        $trend->day = $trend->created_at->day;

        $trend->view = $this->getView($trend->id);

        $trend->username = name_filter($trend->user->username);

        unset($trend->user);

        $trend = [$trend->date=>$trend];

        return ['code'=>1,'msg'=>'产品发布成功待审核','trend'=>$trend,'id'=>$id];

    }

    public function addView($id){

        $trend = Trend::where('id',$id)->first();

        $f_view = $trend->f_view;

        $time = $trend->updated_at->timestamp;     

        $time_sub = (time()-$time)/3600;

        $conf = config('base.view_config.trends');

        $f_view = view_rand($f_view,$time_sub,$conf);

        DB::table('trends')->where('id',$id)->increment('view');

        DB::table('trends')->where('id',$id)->increment('f_view',$f_view);    
        
    }

    public function get_top($id){

        $top = Trend::where('status',1)->where('id',$id)->first();

        $top->username = name_filter($top->user->username);

        $top->uid = name_filter($top->user->id);

        unset($top->user);

        return $top;

    }

    public function AssembleData($id){

        $data = Trend::where('id',$id)

                ->where('status',1)

                ->select('id','title','f_view','updated_at','uid','product_url')

                ->first();
        
        if (empty($data)) {

            return false;
        }

        if (isset($data->type)) {

            $data->type = config('base.dataType')[$data->type];

        }
        
        $data->time = isset($data->updated_at)?$data->updated_at->diffForHumans():'';

        if ($data->user) {
    
            $data->user_name = name_filter($data->user->username);

            $data->user_id = $data->user->id;

            $data->user_image = $data->user->image;

            unset($data->user);

        } 

        return $data;

    }  
}