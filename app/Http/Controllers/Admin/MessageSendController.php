<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Message;
use Illuminate\Support\Facades\DB;
use App\Models\AdminModels\Fall;

class MessageSendController extends Controller
{
    public function message_send_add($uid,$table,$id,$type,$tname,$ctime,Request $request){
        if($request->isMethod('post')){
            $data['from'] = 1;
            $data['to'] = $uid;
            $data['content'] = $request->get('content');
            $data['status'] = 1;
            Message::create($data);
            $status = -2;
            if ($table == 'income'){
                $status = -1;
            }
            DB::table($table)->where('id',$id)->update(['status' => $status]);
        }else{
            $index = $request->get('index');
            $utime = date('Y-m-d H:i:s');
            if ($table == 'applicant_author') {
                if (intval($type) == 1){
                    $str = "恭喜！你已成功申请成为菠菜圈认证作者。";
                }else{
                    $str = "您的作者申请未通过审核，请提供正确的认证信息或者与菠菜圈管理员取得联系";
                }
            }elseif($table == 'income'){
                if (intval($type) == 1){
                    $str = "你于$ctime 申请提成的要求，已成功支付。";
                }else{
                    $str = "你于$ctime 申请提成的要求，未审核通过，原因如下：【退回通知输入的原因】";
                }
            }elseif($table == 'micro'){
                if (intval($type) == 1){
                    $str = "你于$tname $ctime 发布的内容，已在$utime 审核通过，期待你发布更多的产业相关动态。";
                }else{
                    Fall::where(['cid' => $id])
                        ->where(['model' => 'Micro'])
                        ->update(
                            ['status' => 0]
                        );
                    $str = "你于$tname $ctime 发布的内容，未审核通过，原因如下：【退回通知输入的原因】";
                }
            }else{
                if (intval($type) == 1){
                    $str = "你于$tname $ctime 发布的内容，已在$utime 审核通过，期待你发布更多的产业相关动态。";
                }else{
                    $str = "你于$tname $ctime 发布的内容，未审核通过，原因如下：【退回通知输入的原因】";
                }
            }
            return view('Admin.message_send.message_send-add',compact('uid','table','id','str','index'));
        }
    }


}
