<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Closure;
class FeedbackPageController extends Controller
{
    protected $passField = [
        'title','content'
    ];
    private $uid;

    public function __construct(Request $request)
    {
        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;
            }
            return $next($request);
        });
    }

    public function addFeedback(Request $request){
        if (!$this->uid){
            $return['code'] = 0;
            $return['msg'] = '抱歉，您需要登录后方可提交此反馈意见！';
            echo json_encode($return);exit();
        }

        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:20',
                'content' => 'required|min:20|max:100',
            ]);
            //数据库操作
            foreach ($request->all() as $key => $val){
                if(in_array($key,$this->passField)){
                    if (!is_numeric($val)){	$val = clean($val);}
                    $data[$key] = $val;
                }
            }
            $data['uid'] = $this->uid;
            $data['addip'] = $request->getClientIp();
            $data['status'] = 0;
            $res = Feedback::create($data);
            if ($res){
                $return['code'] = 200;
                $return['msg'] = '提交成功！';
            }else{
                $return['code'] = 0;
                $return['msg'] = '提交失败,请刷新页面后重试！';
            }
            echo json_encode($return);
            //返回结果
        }
    }
}
