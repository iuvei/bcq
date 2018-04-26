<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\UserDataComment;
class UserData extends Model
{
    protected $table = 'data';

    public function user(){
        //用户 资料 一对多关系
        return $this->belongsTo('App\Models\User','uid','id');
    }

    public function fileinfo(){
        return $this->hasOne('App\Models\File','id','file');
    }

    public function getUserDataList($skip,$limit,$opt){

        if (empty($limit)){

            return [];

        }

        if (!empty($opt['uid'])) {

/*            $dataList = UserData::whereIn('status',[0,1])->where('uid',$opt['uid']);   
*/                     
        $dataList = UserData::where('status',1)->where('uid',$opt['uid']);   

        }elseif (!empty($opt['id'])) {
            $dataList = UserData::whereIn('status',[0,1])->whereIn('id',$opt['id']); 
        }else{
            $dataList = UserData::where('status',1);                        
        }

        if (!empty($opt['type'])) {
            $dataList = UserData::where('type',$opt['type']);
        }

        $dataList = $dataList->latest()->orderBy('sort','desc')->skip($skip)->limit($limit)->get();

        foreach ($dataList as $key=>$data){
            if (isset($opt['is_collected'])){
                $dataList[$key]->is_collected = $this->is_collected($data->id,$opt['is_collected']);
            }
            if(isset($opt['is_comment'])){
                $dataList[$key]->is_comment = $this->isComment($data->id,$opt['is_comment']);
            }
            $dataList[$key]->publish_time = $data->created_at->diffForHumans();

            $dataList[$key]->time = $data->updated_at->diffForHumans();
            //文件详情
            if (isset($data->fileinfo)){

                $dataList[$key]->down = $data->fileinfo->down;

                unset($dataList[$key]->fileinfo);
            }

            if (isset($data->type)) {
                $dataList[$key]->type_id = $data->type;
                $dataList[$key]->type = config('base.dataType')[$data->type];
            }

            $dataList[$key]->keywords = explode(',', $data->keywords);

            unset($dataList[$key]->view);

            unset($dataList[$key]->sort);

            unset($dataList[$key]->status);

            unset($dataList[$key]->updated_at);

            if ($data->user){

                $dataList[$key]->username = name_filter($data->user->username);

                unset($dataList[$key]->user);
            }
        }
        return $dataList;
    }

    public function getView($id){//获取浏览量

        $obj = UserData::find($id);

        return $obj->f_view;
    }

    public function isComment($did,$uid){//获取评论数量

        $comment = DB::table('data_comment')->where('did',$did)->where('uid',$uid)->whereNull('dcid')->where('status',1)->first();

        return $comment;
    }

    public function getComment($id){//获取评论数量

        $comment = DB::table('data_comment')->where('did',$id)->whereNull('dcid')->where('status',1)->count();

        return $comment;
    }

    public function getCollection($id){//获取收藏数量

        $collection = DB::table('data_collection')->where('status',1)->where('did',$id)->count();

        return $collection;
    }

    public function is_collected($did,$uid){

        $is_collected = DB::table('data_collection')->where('uid',$uid)->where('did',$did)->where('status',1)->count();

        return $is_collected;
    }

    public function add_collection($did,$uid){

        $collection = DB::table('data_collection')->where('uid',$uid)->where('did',$did)->first();

        if ($collection){
            if ($collection->status){
                $collection = DB::table('data_collection')->where('uid',$uid)->where('did',$did)->update(['status'=>0]);
            }else{
                $collection = DB::table('data_collection')->where('uid',$uid)->where('did',$did)->update(['status'=>1]);
            }
        }else{
            $collection = DB::table('data_collection')->insert(['uid'=>$uid,'did'=>$did,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        }

        if (!$collection){
            return ['code'=>0,'msg'=>'update status fail'];
        }

        return ['code'=>1,'msg'=>'update status success'];
    }

    public function getDetails($did,$uid=''){//参数uid是指当前登录用户
        //数据库查的uid是指发布资料的用户
        $user_data = UserData::where('status',1)->where('id',$did)->select('id','uid','title','brief','file','keywords','type','suffix','f_view','price','created_at')->first();

        if (!$user_data){
            return [];
        }
        $user_data->view = $user_data->f_view;
        $user_data->down = $user_data->fileinfo->down;//获取下载数量
        unset($user_data->fileinfo);
        if (isset($user_data->type)) {
            $user_data->type_id = $user_data->type;
            $user_data->type = config('base.dataType')[$user_data->type];
        }
        $user_data->comment_list = UserDataComment::getCommentList($user_data->id);
        $user_data->collection = $this->getCollection($user_data->id);
        if ($uid) {
            $user_data->is_collected = $this->is_collected($did,$uid);
        }else{
            $user_data->is_collected = 0;
        }
        $user_data->comment = $this->getComment($user_data->id);
        $user_data->user;
        $user_data->user->author_info;
        return $user_data;
    }

    public function addUserData($datas){

        if($datas['id']){
            $obj = UserData::where('id',$datas['id'])->first();
            unset($datas['id']);
        }else{
            $obj = new UserData();
        }
        foreach ($datas as $key=>$data){
            if (isset($data)){
                $obj->$key = $data;
            }
        }

        $obj->save();

        return ['code'=>1,'msg'=>'add success'];
    }

    static function deleteUserData($id){

        $obj = UserData::where('id',$id)->first();

        $obj->status = 0;

        $obj->save();        

    }

    static function getEdits($id,$uid){//编辑我上传的资料时要获取前一次的提交内容
        
        $user_data = UserData::where('id',$id)->where('uid',$uid)->select('id','title','brief','keywords','type','suffix','price')->first();

        return $user_data; 
    }

    public function Search($keywords){

        $search = UserData::where('status',1);              

        if(!trim($keywords)){

            $search = $search->limit(10);

        }else{

            $keywords = '%'.$keywords.'%';

            $search = $search->where('title','like',$keywords);
        }

        $search = $search

                ->select('id','uid','title','view','brief','updated_at')

                ->orderBy('view','desc')

                ->latest()

                ->limit(20)

                ->get();

        foreach ($search as $key => $value) {
            $search[$key]->time = isset($value->updated_at)?$value->updated_at->diffForHumans():'';
            $search[$key]->username = name_filter($value->user->username);
            $search[$key]->collection = $this->getCollection($value->id);   
            $search[$key]->brief = $search[$key]->describe;           
            unset($search[$key]->user);     
        }

        return $search;
    }

    public function addView($id){

        $userdata = UserData::where('id',$id)->first();

        $f_view = $userdata->f_view;

        $time = $userdata->updated_at->timestamp;     

        $time_sub = (time()-$time)/3600;

        $conf = config('base.view_config.userdata');

        $f_view = view_rand($f_view,$time_sub,$conf);

        DB::table('data')->where('id',$id)->increment('view');

        DB::table('data')->where('id',$id)->increment('f_view',$f_view);    

    }  

    public function get_hot_download(){

        $week_ago = date('Y-m-d', strtotime('-7 days'));

        $hot_download = DB::table('data')->where('data.status',1)

        ->join('file','data.file','=','file.id')

        ->where('data.created_at','>',$week_ago)

        ->select('data.id','data.title')

        ->orderBy('file.down','desc')

        ->limit(10)

        ->get();

        return $hot_download;        
    }

    static function upload_count($uid){

        $count = UserData::whereIn('status',[0,1])->where('uid',$uid)->count();

        return $count;

    }         


    public function AssembleData($id){

        $data = UserData::where('id',$id)

                ->where('status',1)

                ->select('id','title','f_view','updated_at','type','uid')

                ->first();
        
        if (empty($data)) {

            return false;
        }

        if (isset($data->type)) {

            $data->type = config('base.dataType')[$data->type];

        }
        
        $data->time = isset($data->updated_at)?$data->updated_at->diffForHumans():'';

        $data->comment = $this->getComment($id);

        $data->collection = $this->getCollection($id);

        if ($data->user) {
    
            $data->user_name = name_filter($data->user->username);

            $data->user_id = $data->user->id;

            $data->user_image = $data->user->image;

            unset($data->user);

        }

        return $data;

    }       
}
