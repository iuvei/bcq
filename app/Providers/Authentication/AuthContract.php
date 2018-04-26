<?php

namespace App\Providers\Authentication;

interface AuthContract{

    public function getVerificationCode($zonecode,$phone);//获取验证码 $phone手机号码

    public function verifyCode($phone,$authCode);//校验验证码 $phone手机号码 $authCode验证码

}