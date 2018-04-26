<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Authentication;
use App\Models\User;
use App\Models\Author;
use Illuminate\Support\Facades\Cookie;
class AccountController extends Controller
{
    private $user;

    private $login_key;

    public function __construct()
    {
        $this->user = new User();

        $this->login_key = config('etc.account.login_key');
    }

    public function register(Request $request){


        $data = $request->input('register');

        $phone = $request['zonecode'].$data['phone'];

        $psd = $data['psd'];

        $psdconfirm = $data['psdconfirm'];    

        $username = trim($data['username']);

        $authCode = $data['authCode'];

        $regip = $request->getClientIp();   

        if (!$phone){
            echo json_encode(['code'=>0,'msg'=>'请输入合法手机号']);
            die;
        }elseif (strlen($psd) < 6||strlen($psd) > 18){
            echo json_encode(['code'=>0,'msg'=>'密码不得少于6位']);
            die;
        }elseif ($psd != $psdconfirm){
            echo json_encode(['code'=>0,'msg'=>'请确保密码输入一致']);
            die;
        }elseif(!preg_match("/^[a-z\d]*$/i",$psd)){  
            echo json_encode(['code'=>0,'msg'=>'密码只能包含数字、字母及下划线']);
            die;
        }        

        $verify = Authentication::verifyCode($phone,$authCode);

        if (!$verify['code']){

            echo json_encode(['code'=>0,'msg'=>$verify['msg']]);

            die();
        }

        if (!$psd){

            echo json_encode(['code'=>0,'msg'=>'密码不得为空']);

            die();

        }elseif ($psd!=$psdconfirm){

            echo json_encode(['code'=>0,'msg'=>'请确认两次密码输入一致']);

            die();
        }elseif(!$username){

            echo json_encode(['code'=>0,'msg'=>'请填写您的昵称']);

            die();
        }

        $ret = $this->user->addNewUser($phone,$username,$psd,$regip);

        if (!$ret['code']){
            echo json_encode($ret);
            die();
        }

        put_session($this->login_key,$ret['user']->id);

        echo json_encode($ret);

    }

    public function login(Request $request){

        $data = $request->input('login');

        $phone = $request['zonecode'].$data['phone'];

        $psd = $data['psd'];

        $remeber = $data['remember'];

        if (!$phone||!$psd){
            echo json_encode(['code'=>0,'msg'=>'账号密码不得为空']);
            die;
        }

        $ip = $request->getClientIp();

        $ret = $this->user->userLogin($phone,$psd,$ip);

        if (!$ret['code']){
            echo json_encode($ret);
            die;
        }

        put_session($this->login_key,$ret['user']->id);

        if(Author::is_author($ret['user']->id)){
            $ret['user']->is_author = 1;
        }else{
            $ret['user']->is_author = 0;
        }

        if ($remeber){

            Cookie::queue($this->login_key,$ret['user']->id,60*24*30);

        }

        echo json_encode($ret);

    }

    public function resetPassword(Request $request){

        $data = $request->input('reset');

        $phone = $request['zonecode'].$data['phone'];

        $psd = $data['psd'];

        $psdconfirm = $data['psdconfirm'];

        if (!$phone){
            echo json_encode(['code'=>0,'msg'=>'请输入合法手机号']);
            die;
        }elseif (strlen($psd) < 6||strlen($psd) > 18){
            echo json_encode(['code'=>0,'msg'=>'密码不得少于6位']);
            die;
        }elseif ($psd != $psdconfirm){
            echo json_encode(['code'=>0,'msg'=>'请确保密码输入一致']);
            die;
        }

        $ret = $this->user->resetPassword($phone,$psd);

        echo json_encode($ret);

    }

    public function isLogin(Request $request){

        $user_info =  get_user_info();

        if ($user_info['code'] !== 1){

            echo json_encode(['code'=>0,'not login']);
            
            die;
        }

        if(Author::is_author($user_info['user']->id)){
            $user_info['user']->is_author = 1;
        }else{
            $user_info['user']->is_author = 0;
        }

        echo json_encode(['code'=>1,'user_info'=>$user_info['user']]);
    }

    public function logout(Request $request){

        if ($request->cookie($this->login_key)){

            Cookie::queue($this->login_key,'',-1);

        }

        put_session($this->login_key,'',true);

        if (!has_session($this->login_key)){

            echo json_encode(['code'=>1,'msg'=>'已退出登陆']);

        }
    }



}
