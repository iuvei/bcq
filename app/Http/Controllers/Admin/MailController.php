<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Mail;

class MailController extends Controller
{
    protected $passField = [
        'title','content','sort','type','status'
    ];

    public function mail_list(Request $request){
        if($request->isMethod('post')){
            $opt = array();

            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
                $orOpt['content'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Mail::getMail(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.mail.mail-list',compact('object'));
    }

    public function mail_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Mail::getMail($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Mail = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Mail['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Mail::getMailCount();
            $Mail['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Mail);

        //dd($object['mail']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function mail_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'content' => 'required|max:200',
                'sort' => 'integer',
                'type' => 'required',
                'status' => 'required',
            ]);
            //数据库操作
            $data = [];
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    $data[$key] = $val;
                }
            }
            Mail::create($data);
            //返回结果
        }
        return view('Admin.mail.mail-add');
    }

    public function mail_edit(Mail $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'content' => 'required|max:200',
                'sort' => 'integer',
                'type' => 'required',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    $obj->$key = $val;
                }
            }
            $obj->save();
            //返回结果
        }
        return view('Admin.mail.mail-edit',compact('obj'));
    }
    public function ajax_get_file(Mail $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Mail();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
