<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
class Business extends Model
{
    protected $table = 'business';

    protected $hidden = ['status','created_at'];

    public function Slide()
    {
        return $this->morphMany('App\Models\Slide', 'Slide');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','uid','id');
    }

    public function getBusinessList($skip,$limit,$opt){

        if (!isset($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        
        $businessList = Business::where('status',1);

        if ($businessList->get()->isEmpty()) {
            return [];
        }
        if(isset($opt['except_id'])){
            $businessList = $businessList->where('id','<>',1);
        }

/*        if(isset($opt['hot'])){
            $businessList = $businessList->where('hot',1);
        }*/

        if(isset($opt['uid'])){
            $businessList = $businessList->where('uid',$opt['uid']);
        }

        if (isset($opt['type'])&&$opt['type'] == 1){
            $businessList = $businessList->where('type',1)->orderBy('hot','desc');
        }

        if (isset($opt['type'])&&$opt['type'] == 2){
            $businessList = $businessList->where('type',2)->orderBy('hot','desc');
        }

        $businessList = $businessList->select('id','confirm','type','title','brief','bid','created_at','updated_at')->skip($skip)->limit($limit)->orderBy('confirm','desc')->orderBy('updated_at','desc')->get();

        foreach ($businessList as $key=>$business){
            //用户收藏情况
            if (isset($opt['is_collected'])&&$opt['is_collected']) {

                $businessList[$key]->is_collected = $this->is_collected($business->id,$opt['is_collected']);

            }

            $businessList[$key]->time = $business->updated_at->diffForHumans();

            $businessList[$key]->category = $this->category($business->bid);

        }
        return $businessList;

    }

    public function filter($type,$bid,$confirm,$limit,$skip){
        if (!isset($type)||!isset($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $businessList = Business::where('status',1)->where('type',$type);

        if ($bid){
            $businessList = $businessList->whereIn('bid',$bid);
        }
        if ($confirm == 'true'){
            $businessList = $businessList->where('confirm',1);
        }
        $businessList = $businessList->select('id','confirm','title','brief','bid','created_at','updated_at')
            /*->orderBy('hot','desc')*/->orderBy('confirm','desc')->latest()->skip($skip)->limit($limit)->get();
        foreach ($businessList as $key=>$business){

            $businessList[$key]->time = $business->updated_at->diffForHumans();

            $businessList[$key]->category = $this->category($business->bid);

        }

        return $businessList;
    }


    public function getView($id){//获取浏览量

        $obj = Business::find($id);

        return $obj->f_view;
    }

    public function addView($id){

        $business = Business::where('id',$id)->first();

        $f_view = $business->f_view;

        $time = $business->updated_at->timestamp;     

        $time_sub = (time()-$time)/3600;

        $conf = config('base.view_config.userdata');

        $f_view = view_rand($f_view,$time_sub,$conf);

        DB::table('business')->where('id',$id)->increment('view');

        DB::table('business')->where('id',$id)->increment('f_view',$f_view);    

    }  

    public function getTop($id){//获取点赞的数量

        $obj = Business::find($id);

        return $obj->top;
    }

    public function getCollection($id){//获取收藏数量

        $obj = Business::find($id);

        $hot = DB::table('pb_collection')->where('pbid',$obj->id)->where('type',1)->count();

        return $hot;
    }

    public function is_collected($pbid,$uid){

        $is_collected = DB::table('pb_collection')->where('uid',$uid)->where('pbid',$pbid)->where('type',1)->count();

        return $is_collected;
    }


    public function category($id){

        $category = DB::table('bcategory')->where('id',$id)->select('id','fid','cname')->first();

        return $category;

    }

    public function getSonCategory($fid){

        $son_categories = DB::table('bcategory')->where('fid',$fid)->select('id')->get();

        $catergory_id = [];

        foreach ($son_categories as $son_category){

            $catergory_id[] = $son_category->id;

        }

        return $catergory_id;
    }

    public function businessConfirm($id,$uid){//已认证平台信息 $id为 主键id  //$uid是指当前登录用户的id，未登录时为null

        $business = Business::whereIn('status',[0,1])->where('id',$id)->with(['user' => function ($query) {
            $query->select('id','username');
        }])->first();
        $business->user->username = name_filter($business->user->username);
        $business->collection = $this->getCollection($id);//获取收藏数量
        $business->category = $this->category($business->bid);//获取商讯分类

        if (!empty($uid)){
            $business->is_collected = $this->is_collected($business->id,$uid);
        }

        if (!intval($business->status) && $business->uid != $uid){
            $business = [];
        }

        return $business;
    }

    public function Search($keywords){

        $search = Business::where('status',1);              

        if(!trim($keywords)){

            $search = $search->limit(10);

        }else{

            $keywords = '%'.$keywords.'%';

            $search = $search->where('title','like',$keywords);
        }

        $search = $search

                ->select('id','uid','title','brief','updated_at')

                ->orderBy('view','desc')

                ->latest()
                
                ->limit(20)
                
                ->get();

        foreach ($search as $key => $value) {
            $search[$key]->time = isset($value->updated_at)?$value->updated_at->diffForHumans():'';
            $search[$key]->username = name_filter($value->user->username);
            $search[$key]->view = $this->getView($value->id);
            $search[$key]->collection = $this->getCollection($value->id);   
            $search[$key]->brief = $search[$key]->describe;           
            unset($search[$key]->user);     
        }

        return $search;
    }

    public function updated_flash($id){

        $flush_obj = Business::find($id);

        $falls_obj = get_model_obj('Falls');

        if(isset($flush_obj->id)){

            $flush_obj->updated_at = Carbon::now();
            
            $flush_obj->save();

            $falls = $falls_obj->where('model','Business')->where('cid',$flush_obj->id)->first();

            if (!empty($falls)) {
            
                $falls->updated_at = Carbon::now();

                $falls->save();
                
            }
        }       
    }

    public function AssembleData($id){

        $data = Business::where('id',$id)

                ->where('status',1)

                ->select('id','title','f_view','updated_at','uid','type')

                ->first();
        
        if (empty($data)) {

            return false;
        }
        
        $data->time = isset($data->updated_at)?$data->updated_at->diffForHumans():'';

        $data->collection = $this->getCollection($id);

        if ($data->user) {
    
            $data->user_name = name_filter($data->user->username);

            $data->user_id = $data->user->id;

            $data->user_image = $data->user->image;

            unset($data->user);

        }         

        return $data;

    }        


    public function getDetail($id,$uid){

        $data = Business::where('id',$id)

        ->where('uid',$uid)

        ->where('status',-2)

        ->select('id','bid','content','title','pic','url','contactperson','phone','qq','skype','wechat')

        ->first();

        return $data;
    }
}
