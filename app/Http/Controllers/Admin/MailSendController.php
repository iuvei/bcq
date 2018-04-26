<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\MailSend;
use App\Models\AdminModels\Mail;
use App\Models\AdminModels\User;

class MailSendController extends Controller
{
    protected $passField = [
        'to','mid','status'
    ];

    public function mail_send_list($mid,Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['username'] = array('like','%'.$sSearch.'%');
                $orOpt['phone'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = MailSend::getHasMail(0,10,true,$orOpt,$betweenOpt,$mid);
        }else{
            $object = array();
        }
        return view('Admin.mail_send.mail_send-list',compact('object','mid'));
    }

    public function mail_send_ajax_list($mid,Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['username'] = array('like','%'.$sSearch.'%');
            $orOpt['phone'] = array('like','%'.$sSearch.'%');
        }

        $object = MailSend::getHasMail($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt,array(),$mid);
        $MailSend = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $MailSend['iTotalDisplayRecords'] = count($object);
        } else {
            $count = MailSend::getHasMailCount($mid);
            $MailSend['iTotalDisplayRecords'] = $count;
        }
        return json_encode($MailSend);

        //dd($object['mail_send']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function mail_send_add($mid,Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['username'] = array('like','%'.$sSearch.'%');
                $orOpt['phone'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = User::getNotMail(0,10,true,$orOpt,$betweenOpt,$mid);
        }else{
            $object = array();
        }
        return view('Admin.mail_send.mail_send-add',compact('object','mid'));
    }

    public function mail_send_ajax_add($mid,Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['username'] = array('like','%'.$sSearch.'%');
            $orOpt['phone'] = array('like','%'.$sSearch.'%');
        }

        $object = User::getNotMail($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt,array(),$mid);
        $MailSend = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $MailSend['iTotalDisplayRecords'] = count($object);
        } else {
            $count = User::getNotMailCount($mid);
            $MailSend['iTotalDisplayRecords'] = $count;
        }
        return json_encode($MailSend);

        //dd($object['mail_send']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function mail_send_insert(Mail $obj,Request $request){
        $nidList = explode(',',$request->get('id_list'));
        if ($nidList){
            $data = array();
            foreach ($nidList as $val){
                $data[] = ['to' => intval($val),'status' => 1];
            }
            $res = $obj->mail_send()->createMany($data);
        }else{
            $res = array();
        }

        if($res){
            $return['code'] = 1;
        }else{
            $return['code'] = 0;
        }
        return json_encode($return);
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new MailSend();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
