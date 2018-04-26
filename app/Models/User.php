<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['phone','password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','status','lastlogindate','lastloginip','regip','grasp','vip','viptime','regdate'
    ];

    public function author_info(){
        return $this->hasOne('App\Models\Author','uid','id');
    }

    public function addNewUser($phone,$username,$password,$regip){//新用户注册

        $user = new User;

        $hasuser = $user->where('phone',$phone)->first();

        if ($hasuser){
            return ['code'=>0,'msg'=>'该账号已注册'];
        }

        $hasusername = $user->where('username',$username)->first();

        if ($hasusername){
        
            return ['code'=>0,'msg'=>'该用户名已被注册'];
        }

        $user->phone = $phone;

        $user->username = $username;

        $user->image = config('base.news_user_avatar');

        $user->password = $this->psdEncry($password);

        $user->regip = $regip;

        $create = $user->save();

        if (!$create){
            return ['code'=>0,'msg'=>'注册失败，请重试'];
        }

        $userInfo = User::where('phone',$phone)->first();

        return ['code'=>1,'msg'=>'创建成功','user'=>$userInfo];

    }

    public function userLogin($phone,$password,$ip){//用户登录

        $userInfo = User::where('phone',$phone)->first();

        if (!$userInfo){
//type是错误类型
            return ['code'=>0,'type'=>0,'msg'=>'手机号尚未注册'];
        }

        if ($this->psdEncry($password) != $userInfo->password){
            return ['code'=>0,'type'=>1,'msg'=>'密码输入错误'];
        }

        $userInfo->lastlogindate = time();

        $userInfo->lastloginip = $ip;

        $userInfo->save();

        return ['code'=>1,'user'=>$userInfo,'msg'=>'登陆成功'];

    }

    public function resetPassword($phone,$password){

        $userInfo = User::where('phone',$phone)->first();

        if (!$userInfo){

            return ['code'=>0,'msg'=>'手机号尚未注册'];

        }

        $userInfo->password = $this->psdEncry($password);

        $ret = $userInfo->save();

        if (!$ret){
            return ['code'=>0,'msg'=>'修改失败，请重试'];
        }

        return ['code'=>1,'msg'=>'密码重置成功','user_id'=>$userInfo->id];

    }

    public function psdEncry($password){

        $password_salt = 'PASSWORD_SALT';

        $psdstr = $password_salt.$password;

        $psdencry = substr(md5($psdstr),6,18);

        return $psdencry;

    }

    static function getUserInfo($user_id){//获取用户信息

        $user = User::where('status',1)->where('id',$user_id)->first();

        return $user;
    }

    public function getUserSimpleInfo($user_id){
        
        $user = User::where('status',1)
            ->select('id','username','image','price','brief','desc')
            ->where('id',$user_id)
            ->first();

        $user->username = name_filter($user->username);        

        return $user;

    }

    public function setNewPrice($uid,$price,$type){//设置新价格

        $user_obj = User::where('id',$uid)->first();

        if (!empty($user_obj)){
            if ($type == 'add'){
                $user_obj->price += $price;
            }elseif ($type == 'deduct')
                $user_obj->price -= $price;
                if ($user_obj->price < 0){
                    return ['code'=>0,'msg'=>'种子数不足'];
                }
            $user_obj->save();
        }
        return ['code'=>1,'msg'=>'种子数刷新'];
    }

    public function getAttentionCount($uid){//获取关注数量

        $count = DB::table('author_attention')->where('status',1)->where('uid',$uid)->count();

        return $count;
    }

    public function getFansCount($aid){//获取粉丝数量

        $count = DB::table('author_attention')->where('status',1)->where('aid',$aid)->count();

        return $count;
    }

    public function getFanList($auid,$skip,$limit,$uid=''){//获取用户的粉丝列表
        $fans_id_list = DB::table('author_attention')
            ->where('aid',$auid)
            ->where('status',1)
            ->skip($skip)
            ->limit($limit)
            ->pluck('uid');

        $fans_list = DB::table('users')
            ->whereIn('users.id',$fans_id_list)
            ->select('id','username','image','brief')
            ->get();

        foreach ($fans_list as $key => $value) {
            if ($uid) {
                $fans_list[$key]->is_attention = self::is_attention($value->id,$uid);
            }else{
                $fans_list[$key]->is_attention = 0;
            }
            $fans_list[$key]->username = name_filter($value->username);
        }

        return $fans_list;
    }

    public function getAttentionList($auid,$skip,$limit){//获取用户关注列表
        
        $attention_id_list = DB::table('author_attention')
            ->where('uid',$auid)
            ->where('status',1)
            ->skip($skip)
            ->limit($limit)
            ->pluck('aid');

        $attention_list = DB::table('users')
            ->whereIn('users.id',$attention_id_list)
            ->select('id','username','image','brief')
            ->get();

        foreach ($attention_list as $key => $value) {
            $attention_list[$key]->username = name_filter($value->username);
        }    
        return $attention_list;
    }

    public function getNewsCount($uid){//获取文章字数

        $count = DB::table('news')->where('status',1)->where('uid',$uid)->sum('count');

        return $count;

    }

    public function authorCheck($uid){
        $is_author = DB::table('user_author')
        ->where('status',1)
        ->where('uid',$uid)
        ->select('desc','id')
        ->first();
        if (!empty($is_author)){
            return ['code'=>1,'msg'=>'您已是作者','info'=>$is_author];
        }else{
            return ['code'=>0,'msg'=>'尚未成为作者'];
        }
    }

    public function authorCreation($uid){
        $creation = DB::table('news')
            ->leftJoin('author_class','news.ucid','=','author_class.id')
            ->where('news.uid',$uid)
            ->whereIn('news.status',[-1,-2,-3])
            ->select('news.id','news.uid','news.ucid','news.title','news.locked','news.count','news.status','author_class.cname')
            ->get();
        return $creation;
    }

    public function authorCategory($uid){
        $author_class = DB::table('author_class')->where('status',1)->where('uid',$uid)->select('id','cname')->get();

        return $author_class;
    }

    public function add_attention($aid,$uid){//需求更改 --- aid是指被關注的用戶的id

        $attention = DB::table('author_attention')->where('uid',$uid)->where('aid',$aid)->first();

        if ($attention){
            if ($attention->status == 1){
                $attention = DB::table('author_attention')->where('uid',$uid)->where('aid',$aid)->update(['status'=>0]);
                $msg = '取消关注';
            }else{
                $attention = DB::table('author_attention')->where('uid',$uid)->where('aid',$aid)->update(['status'=>1]);
                $msg = '关注成功';
            }

        }else{
            $attention = DB::table('author_attention')->insert(['uid'=>$uid,'aid'=>$aid,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            $msg = '关注成功';
        }

        if (!$attention){
            return ['code'=>0,'msg'=>'关注失败'];
        }

        return ['code'=>1,'msg'=>$msg];
    }

    static function is_attention($aid,$uid){

        if ($aid == $uid){
            $is_attention = -1;
        }else{
            $is_attention = DB::table('author_attention')->where('aid',$aid)->where('uid',$uid)->where('status',1)->count();
        }
        return $is_attention;
    }    


}
