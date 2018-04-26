<?php

namespace App\Http\Controllers\Front;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ApplicantAuth;
use App\Models\Author;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use Closure;
class ApplicantAuthController extends Controller
{

    protected $uid;

    protected $authorOpt;

    protected $passField = ['phone','interest','desc','links'];

    public function __construct(Request $request){

        $this->authorOpt = ['order_by_update'=>1];

        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;
                //登陆后才显示关注状态
                $this->authorOpt = ['order_by_update'=>1,'is_attention'=>$this->uid];
            }

            return $next($request);

        });
    }

    public function addAuth(Request $request){
        if (!$this->uid){
            $return['code'] = 0;
            $return['msg'] = '请在登录后提交信息！';
            echo json_encode($return);
            exit();
        }
        $is_author = Author::is_author($this->uid);
        if ($is_author){
            $return['code'] = 200;
            $return['msg'] = '您已是作者，请勿重复提交申请！';
            echo json_encode($return);
            exit();
        }
        $is_publish = ApplicantAuth::isPublish($this->uid);
        if ($is_publish){
            $return['code'] = 200;
            $return['msg'] = '您已提交过申请信息，请等待审核或联系在线客服！';
            echo json_encode($return);
            exit();
        }

        //验证
        $this->validate(request(), [
            'name' => 'required|max:20',
            'phone' => 'required|max:15',
            'interest' => 'required',
            'desc' => 'required|min:20|max:200',
            'links' => 'max:200',

        ]);
        //数据库操作
        $user = User::where('id',$this->uid)->first();
        $user->username = request('name');
        $user->save();
        foreach ($request->all() as $key => $val){

            if(in_array($key,$this->passField)){
                if($key == 'interest'){
                    $data[$key] = implode(',',$val);
                }else{
                    if (!is_numeric($val)){	$val = clean($val);}
                    $data[$key] = $val;
                }
            }
        }
        $data['uid'] = $this->uid;
        $data['addip'] = $request->getClientIp(); ;

        $res = ApplicantAuth::create($data);

        if ($res){
            $return['code'] = 200;
            $return['namecode'] = 200;
            $return['msg'] = '提交成功！';
        }else{
            $return['code'] = 0;
            $return['msg'] = '提交失败,请刷新页面后重试！';
        }
        //返回结果
        echo json_encode($return);

    }


}
