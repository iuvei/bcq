<?php

namespace App\Http\Controllers\Front\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
class UserInfoController extends UserCenterController
{
    public function modify_info(Request $request){

        $user_data = $request->input('user_data');

        $valid = ['username','brief','email','qq','wechat','skype','job','city','desc'];

        $hasusername = User::where('username',$user_data['username'])->first();

        if ($hasusername&&($user_data['username']!=$this->user_obj->username)) {
            echo json_encode(['code'=>0,'msg'=>'用户名已存在，请更换用户名']);
            die;   
        }

        $hasdesc = User::where('desc',$user_data['desc'])->first();

        if ($hasdesc&&($user_data['desc']!=$this->user_obj->desc)) {
            echo json_encode(['code'=>0,'msg'=>'个人标签已存在，请换一个标签吧']);
            die;   
        }
        foreach($user_data as $key=>$value){

            if (($user_data[$key] !== $this->user_obj->$key)&&in_array($key, $valid)) {

               $this->user_obj->$key = clean($value);
               
            }
        }

        $this->user_obj->save();

        echo json_encode(['code'=>1,'user_info'=>$this->user_obj]);
    }

}

