<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
class Platform extends Model
{
    protected $table = 'platform';

    protected $hidden = ['status','created_at'];

    public function Slide()
    {
        return $this->morphMany('App\Models\Slide', 'Slide');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','uid','id');
    }

    public function getPlatformList($skip,$limit,$opt){

        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $platformList = Platform::where('status',1);

/*        if(isset($opt['hot'])){//是否是推荐
            $platformList = $platformList->where('hot',1);
        }
*/
        if(isset($opt['except_id'])){//是否是除了这个 id 的其他推荐
            $platformList = $platformList->where('id','<>',$opt['except_id']);
        }
        if (isset($opt['type'])&&$opt['type'] == 1){
            $platformList = $platformList->where('type',1);
        }
        if (isset($opt['type'])&&$opt['type'] == 2){
            $platformList = $platformList->where('type',2);
        }

        if (isset($opt['uid'])&&$opt['uid']){
            $platformList = $platformList->where('uid',$opt['uid']);
        }

        $platformList = $platformList->select('id','confirm','title','brief','logo','games','hot','created_at','updated_at')
            ->orderBy('confirm','desc')->orderBy('updated_at','desc')->skip($skip)->limit($limit)->get();

        //用户收藏情况
        if (isset($opt['is_collected'])&&$opt['is_collected']) {

            foreach ($platformList as $key=>$platform) {
                $platformList[$key]->is_collected = $this->is_collected($platform->id,$opt['is_collected']);
            }
        }

        foreach($platformList as $key=>$platform){

            $platformList[$key]->time = $platform->updated_at->diffForHumans();

            $platformList[$key]->games = convert_type($platform->games,config('etc.games'));

        }

        return $platformList;
    }

    public function getView($id){//获取浏览量

        $obj = Platform::find($id);

        return $obj->f_view;
    }

    public function addView($id){

        $platform = Platform::where('id',$id)->first();

        $f_view = $platform->f_view;

        $time = $platform->updated_at->timestamp;     

        $time_sub = (time()-$time)/3600;

        $conf = config('base.view_config.userdata');

        $f_view = view_rand($f_view,$time_sub,$conf);

        DB::table('platform')->where('id',$id)->increment('view');

        DB::table('platform')->where('id',$id)->increment('f_view',$f_view);    
    
    }


    public function getTop($id){//获取点赞的数量

        $obj = Platform::find($id);

        return $obj->top;
    }

    public function addTop($id){

        DB::table('platform')->where('id',$id)->increment('top');

        return ['code' => 1, 'msg' => 'add success'];
    }

    public function getCollection($id){//获取收藏数量

        $collection = DB::table('pb_collection')->where('pbid',$id)->where('type',2)->count();

        return $collection;
    }

    public function is_collected($pbid,$uid){

        $is_collected = DB::table('pb_collection')->where('uid',$uid)->where('pbid',$pbid)->where('type',2)->count();

        return $is_collected;
    }

    public function add_collection($pbid,$uid){

        $collection = DB::table('pb_collection')->where('uid',$uid)->where('type',2)->where('pbid',$pbid)->first();

        if ($collection){
            if ($collection->status){
                $collection = DB::table('pb_collection')->where('uid',$uid)->where('type',2)->where('pbid',$pbid)->update(['status'=>0]);
            }else{
                $collection = DB::table('pb_collection')->where('uid',$uid)->where('type',2)->where('pbid',$pbid)->update(['status'=>1]);
            }
        }else{
            $collection = DB::table('pb_collection')->insert(['uid'=>$uid,'type'=>2,'pbid'=>$pbid,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        }

        if (!$collection){
            return ['code'=>0,'msg'=>'update status fail'];
        }

        return ['code'=>1,'msg'=>'update status success'];
    }

    public function filter($type,$game,$settlement,$confirm,$limit,$skip){

        if (!isset($type)||!isset($limit)||!isset($skip)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $platformList = Platform::where('status',1)->where('type',$type);

        if ($game){
            $platformList = $platformList->where('games','&',$game);
        }
        if ($settlement){
            $platformList = $platformList->whereIn('settlement',$settlement);
        }
        if ($confirm == 'true'){
            $platformList = $platformList->where('confirm',1);
        }
        $platformList = $platformList->select('id','confirm','title','brief','logo','type','games','created_at','updated_at')
            ->orderBy('confirm','desc')->latest()->skip($skip)->limit($limit)->get();

        foreach($platformList as $key=>$platform){

            $platformList[$key]->time = $platform->updated_at->diffForHumans();

            $platformList[$key]->games = convert_type($platform->games,config('etc.games'));

        }
        return $platformList;
    }


    public function platformConfirm($id,$uid){//已认证平台信息 $id为 主键id  //$uid是指当前登录用户的id，未登录时为null

        $platform = Platform::whereIn('status',[0,1])->where('id',$id)->with(['user' => function ($query) {
            $query->select('id','username');
        }])->first();
        $platform->user->username = name_filter($platform->user->username);
        $platform->collection = $this->getCollection($id);//获取收藏数量
        $gameList = [];//获取主营游戏
        foreach (config('base.games') as $k => $v){
            if ($k & $platform->games){
                $gameList[$k] = $v;
            }
        }
        $platform->gameList = $gameList;

        $platform->settlementName = config('base.settlement')[$platform->settlement]?config('base.settlement')[$platform->settlement]:'';//获取结算周期

        if (!empty($uid)){
            $platform->is_collected = $this->is_collected($platform->id,$uid);
        }

        if (!intval($platform->status) && $platform->uid != $uid){
            $platform = [];
        }
        return $platform;
    }

    public function updated_flash($id){

        $flush_obj = Platform::find($id);

        $falls_obj = get_model_obj('Falls');

        if(isset($flush_obj->id)){

            $flush_obj->updated_at = Carbon::now();
            
            $flush_obj->save();

            $falls = $falls_obj->where('model','Platform')->where('cid',$flush_obj->id)->first();

            if (!empty($falls)) {
                
                $falls->updated_at = Carbon::now();

                $falls->save();
            }
        }               
    }    

    public function AssembleData($id){

        $data = Platform::where('id',$id)

                ->where('status',1)

                ->select('id','title','f_view','updated_at','uid','type','logo')

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

        $data = Platform::where('id',$id)

        ->where('uid',$uid)

        ->where('status',-2)

        ->select('id','content','title','pic','games','url','settlement','contactperson','phone','qq','skype','wechat')

        ->first();

        return $data;
    }

}
