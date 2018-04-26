<?php
namespace App\Providers\Authentication;
use App\Providers\Authentication\AuthContract as AuthContract;
use Mail;  
const SESSION_KEY = 'verifyCode_';
const MAIL_KEY = 'email_';
const DEDIRECT_URL = '/common/verify_mail';
class AuthService implements AuthContract{

    public function getVerificationCode($zonecode,$phone){

        if (!$phone){
            return ['code'=>0,'msg'=>'手机号码有误'];
        }

        $ret = $this->getCode($zonecode,$phone);

        if (!$ret['code']){
            //error为返回报错
            return ['code'=>0,'msg'=>$ret['msg']];
        }

        $phone = $zonecode.$phone;

        $session_key = SESSION_KEY.$phone;

        put_session($session_key,$ret['authCode']);

        return ['code'=>1,'msg'=>'发送成功'];//$ret;
    }

    public function verifyCode($phone,$authCode){

        if (!$phone){
            return ['code'=>0,'msg'=>'手机号码有误'];
        }

        $session_key = SESSION_KEY.$phone;

        if (!has_session($session_key)){

            return ['code'=>0,'msg'=>'请重新获取验证码'];

        }elseif (get_session($session_key) != $authCode){

            return ['code'=>0,'msg'=>'验证码不匹配'];

        }else{

            $this->unsetCode($phone);

            return ['code'=>1,'msg'=>'验证成功'];
        }
    }

    public function unsetCode($phone){

        put_session(SESSION_KEY.$phone,'',true);

    }

    public function getCode($zonecode,$phone){

        //获取短信验证码的接口------------------

        $verification = rand(1000,9999);       

        if ($zonecode == '86') {

            $api = config('base.phone_code.china.api');
            
            $content = "您的验证码是：".$verification."。请不要把验证码泄露给其他人。";

            $account = config('base.phone_code.china.account');

            $password = config('base.phone_code.china.password');

            $data = ['account'=>$account,'password'=>$password,'mobile'=>$phone,'content'=>$content,'format'=>'json'];


        }else{

            $api = config('base.phone_code.nation.api');
            
            $content = 'Your verification code is '. $verification;

            $account = config('base.phone_code.nation.account');

            $password = config('base.phone_code.nation.password');

            $phone = $zonecode.' '.$phone;

            $data = ['account'=>$account,'password'=>$password,'mobile'=>$phone,'content'=>$content,'format'=>'json'];
        }

        
        $code_ret = json_decode(curl_post($api,$data),true);

        if ($code_ret['code']!=2) {
            
            return ['code'=>0,'msg'=>$code_ret['msg']];
            
        }

        return ['code'=>1,'authCode'=>$verification];        

    }

    public function send_mail_verify($email){

        //windows系统测试邮件发送失败，虚拟机测试成功
        $verify_code = md5(rand(100,999).time());

        $emailData = [
            'verify_url' => '请点击链接完成验证：'.$_SERVER['HTTP_HOST'].DEDIRECT_URL.'?verify_code='.$verify_code,
            'subject' => '菠菜圈邮箱验证',//邮件主题
            'addr' => $email,//邮件接收地址
        ];

        try{

            $tag = $this->sendText($emailData);

        }catch(Exception $e){

            return ['code'=>0,$e->getMessage()];
        }

        put_session($verify_code,$email);

        return ['code'=>1,'msg'=>'验证链接已发送，请登陆邮箱查看'];
    }

    public function sendText($emailData){

        $tag = Mail::raw($emailData['verify_url'],

                function ($message)use ($emailData){

                    $message->subject($emailData['subject']);

                    $message->to($emailData['addr']);

                });

        return $tag;
    } 

    public function verify_mail($code){

        if (!has_session($code)) {

            return ['code'=>0,'msg'=>'邮箱验证码发送失败'];

        }else{

            $email = get_session($code);

            put_session($code,'',true);

            return ['code'=>1,'email'=>$email];

        }
    }

}
