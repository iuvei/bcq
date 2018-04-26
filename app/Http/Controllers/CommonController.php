<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Facades\Authentication;
use App\Models\DownloadRecord;
use App\Models\PriceRecord;
use FileSystem;
use Carbon\Carbon;
use Cache;
use DB;
class CommonController //这个是一些公共的模块，比如获取验证码啊，上传下载什么的
{
    public function get_verification_code(Request $request){//手机验证码

        $phone = $request->input('phone');

        $zonecode = $request['zonecode'];

        $ret = Authentication::getVerificationCode($zonecode,$phone);
        
        echo json_encode($ret);
    }

    public function verify_code(Request $request){//手机验证码

        $phone = $request['zonecode'].$request->input('phone');

        $authCode = $request->input('authCode');

        $verify = Authentication::verifyCode($phone,$authCode);

        echo json_encode($verify);

    }

    public function get_mail_code(Request $request){//使用session时不可以使用die或者exit强制退出，否则不生效

        $email = $request->input('email');

        $ret = Authentication::send_mail_verify($email);

        echo json_encode($ret);
    }
   
    public function verify_mail(Request $request){

        $code = $request->input('verify_code');
     
        if (!$code) {
            return redirect('/');
        }

        $ret = Authentication::verify_mail($code);

        if ($ret['code']) {
            DB::table('users')->where('email',$ret['email'])->update(['email_verify'=>1]);
        }
        return redirect('/user/userpage');
    }

    public function count_test_D($price){//扣除积分检验 检查是否是有效用户，以及积分是否充足

        $user_info = get_user_info();

        if (!$user_info['code']){
            return $user_info;
        }

        $user = $user_info['user'];

        $user_price = $user->price;

        $new_price = $user_price - $price;

        if ($new_price < 0){
            return ['code'=>0,'msg'=>'积分不足，请获取更多积分'];
        }
        return ['code'=>1,'msg'=>'用户积分测试通过','user'=>$user,'new_price'=>$new_price];
    }


    public function Collection($model,$mid){  //收藏行为 $model为模型 $uid 用户ID  $mid 关注模型的 条目ID

        if (!$mid){
            return ['code'=>0,'msg'=>'为选择关注条目'];
        }

        if (!$model){
            return ['code'=>0,'msg'=>'为选择关注类别'];
        }

        $user_info = get_user_info();

        if (!$user_info['code']){

            return ['code'=>0,'msg'=>'请先登陆'];

        }
        $uid = $user_info['user']->id;

        $model_obj = get_model_obj($model);

        $add_ret = $model_obj->add_collection($mid,$uid);

        return $add_ret;
    }

    public function Attention($aid){    //关注行为 $uid用户ID  $aid作者ID //需求已改，不仅可以关注作者，还可以关注用户

        if (!$aid){
            return ['code'=>0,'msg'=>'请选择作者'];
        }
        $user_info = get_user_info();

        if (!$user_info['code']){

            return ['code'=>0,'msg'=>'请先登陆'];

        }
        $uid = $user_info['user']->id;

        if ($uid == $aid){
            return ['code'=>0,'msg'=>'自己关注自己？'];
        }
        $model_obj = get_model_obj('User');

        $add_ret = $model_obj->add_attention($aid,$uid);

        return $add_ret;
    }

    public function AddComment($model,$id,$fid = null,$content){ //id是父评论id  //sid二级id

        $user_info = get_user_info();

        if (!$user_info['code']){

            return ['code'=>0,'msg'=>'请先登陆'];

        }
        $uid = $user_info['user']->id;

        $model_obj = get_model_obj($model);

        $add_ret = $model_obj->add_comment($uid,$id,$fid,$content);

        return $add_ret;
    }

    public function AddCommentTop($model,$id){

        $model_obj = get_model_obj($model);

        $add_ret = $model_obj->add_comment_top($id);

        return $add_ret;
    }

    public function AddComplaint($model,$id){

        $model_obj = get_model_obj($model);

        $add_ret = $model_obj->add_complaint($id);

        return $add_ret;
    }

    public function download_test(Request $request){

        $price = $request->input('price');

        $file = $request->input('file');

        $add_uid = $request->input('uid');

        $type  = $request->input('type');//资料类型 数据报告还是用户资料

        $did = $request->input('did');//资料的主键 id

        if ($request->input('type')==1) {
            $type = 1;
        }else{
            $type = 2;
        }

        $count_test = $this->count_test_D($price);

        if (!$count_test['code']){

            echo json_encode($count_test);
            die;

        }
        $file_test = $this->downloadTask($file);

        if (!$file_test['code']){

            echo json_encode($file_test);
            
            die;
        }

        $user_info = get_user_info();

        if (!$user_info['code']){

            echo json_encode($user_info);

            die;
        }

        $price_fresh = $this->refresh_price($price,$user_info,$add_uid,$type);

        if(!$price_fresh['code']){

            echo json_encode($price_fresh);

            die;
        }

        $add_uid = $add_uid?$add_uid:0;

        PriceRecord::record($add_uid,$type,$did,$price);

        PriceRecord::record($user_info['user']->id,$type,$did,-$price);

        $record_ret = $this->downlaod_record($add_uid,$user_info['user']->id,$did,$type);//下载记录

        echo json_encode(['code'=>1,'资源可下载']);
    }

    public function downloadTask($file_id,$record=false){ //文件下载任务，1.下载文件前的条件检测 2.检测文件资源有效 3.扣除相应积分
        //积分充足的情况下，检测资源是否可以有效下载
        $exists = FileSystem::fileExists($file_id);
        if (!$exists['code']){
            return ['code'=>0,'msg'=>$exists['msg']];
        }
        $pathToFile = FileSystem::downloadFile($file_id,$record);

        if (!$pathToFile['code']){
            return ['code'=>0,'msg'=>$pathToFile['msg']];
        }

        return ['code'=>1,'path'=>$pathToFile['path']];
    }

    public function download_file(Request $request){

        $file_id = $request->input('file');
        //下载需要扣除积分
        //这里要检测是否登录，积分是否充足
        $ret = $this->downloadTask($file_id,true);

        if (!$ret['code']){
            /*echo json_encode($ret);
            die;*/
            die;
        }

        $suffix = explode('.',$ret['path']);

        $name = '资料.'.end($suffix);

        return response()->download($ret['path'],$name);
    }

    public function add_collection(Request $request){

        $cid = $request->input('cid');

        $model = $request->input('model');

        $ret = $this->Collection($model,$cid);

        echo json_encode( $ret);
    }

    public function add_attention(Request $request){

        $aid = $request->input('aid');

        $ret = $this->Attention($aid);

        echo json_encode( $ret);
    }

    public function upload_data_file(Request $request){

        $file = $request->file('upload_file');

        $type = $request->input('type');//type是指data还是report 文件夹名

        $file_info = FileSystem::uploadDataFile($file,$type);//ret 返回file_id

        echo json_encode($file_info);
    }

    public function refresh_price($price,$user_info,$add_uid = '',$type){

        if ($price < 0 || !isset($price)){
            return ['code'=>0,'msg'=>'积分获取错误'];
        }

        $reresh_ret_deduct = $user_info['user']->setNewPrice($user_info['user']->id,$price,'deduct');//扣除用户的种子

        if ($reresh_ret_deduct['code']){

            if ($add_uid){//获取积分的用户ID

                $user_info['user']->setNewPrice($add_uid,$price,'add');
            }
        }
        return $reresh_ret_deduct;
    }

    public function downlaod_record($upid,$doid = 0,$did = 0,$type =1){//上传人id 下载人id 资料id 资料类型 type=1 userdata type=2 report

        $data = ['upid'=>$upid,'doid'=>$doid,'did'=>$did,'type'=>$type];

        DownloadRecord::record($data);

    }

    public function toolsRecord(Request $request){
        //表里面的两条数据要初始化
        //type = 1 打码计算工具 type = 2 开奖号码对比 
        $type = $request->input('type');

        if($type){
           DB::table('tools')->where('type',$type)->increment('use');
        }
    }

    public function search(Request $request){

       $keywords = $request->input('keywords');
       
       $model = $request->input('model');

       $model_obj = get_model_obj($model);

       $search_ret = $model_obj->search($keywords);
       //返回 key 包含 title brief view username time collection 
       echo json_encode($search_ret);

    }

    public function addView($model,$id,$ip){//id是指这个模型的主键id

        $cache_key = $model.'-view-'.$id.'-'.$ip;

        Cache::get($cache_key, function() use ($model,$id,$cache_key){

            $model_obj = get_model_obj($model);        

            $model_obj->addView($id);

            $expire_time = Carbon::tomorrow();

            Cache::put($cache_key,1,$expire_time);

        });
    }

    public function is_author(){

        $user_info = get_user_info();

        if (!$user_info['code']){

            echo json_encode($user_info);

            die;
        }

        $model_obj = get_model_obj('User');        

        $ret = $model_obj->authorCheck($user_info['user']->id);  

        echo json_encode($ret);  
    }

    public function read_status(Request $request){//评论的阅读状态

        $model = $request->input('model');//模型
        
        $status = $request->input('status');//1 为使发布变为评论未读 0 为使发布变为评论已读
        
        if ($status!=0&&$status!=1) {
            echo 'status wrong !';
            die;
        }

        $id = $request->input('id');//模型主键

        try {

            DB::table($model)->where('id',$id)->update(['unread'=>$status]);            
        
        } catch (Exception $e) {

            echo $e->getMessage();
            
            die;    
        } 

    }

    public function flush_limit_by_ip(Request $request){//限制每日刷新次数(点赞，投诉等)

        $type = $request->input('type');

        $id = $request->input('id');

        $ip = $request->getClientIp();

        $cache_key = $type.'-'.$id.'-'.$ip;

        $limit = Cache::get($cache_key, function() use ($cache_key){

            $expire_time = Carbon::tomorrow();

            Cache::put($cache_key,1,$expire_time);

        });        

        echo $limit;
        
        die;
    }

    public function flush_trade_order(Request $request){//交易模块限制每日刷新次数

        $type = $request->input('type');

        $id = $request->input('id');

        $model_obj = get_model_obj($type);

        $cache_key = $type.'-'.$id;

        $limit = Cache::get($cache_key, function() use ($cache_key,$model_obj,$id){

            $model_obj->updated_flash($id);//刷新更新时间

            $expire_time = Carbon::tomorrow();

            Cache::put($cache_key,1,$expire_time);

        });        

        echo $limit;

        die;
    }

    public function IncomeComputer($view){

        $income = $view*12/1000;

        return $income;

    }
}