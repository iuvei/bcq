<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Notice;

class NoticeController extends Controller
{
    protected $passField = [
        'sort','title','image','content','status'
    ];

    public function notice_list(Request $request){
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
            $object = Notice::getNotice(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.notice.notice-list',compact('object'));
    }

    public function notice_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Notice::getNotice($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Notice = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Notice['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Notice::getNoticeCount();
            $Notice['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Notice);

        //dd($object['notice']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function notice_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'sort' => 'integer',
                'title' => 'required|max:40',
                'content' => 'required|max:21845',
                'status' => 'required',
            ]);
            //数据库操作
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $data[$key] = $val;
                }
            }
            Notice::create($data);
            //返回结果
        }
        return view('Admin.notice.notice-add');
    }

    public function notice_edit(Notice $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'sort' => 'integer',
                'title' => 'required|max:40',
                'content' => 'required|max:21845',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                }
            }
            $obj->save();
            //返回结果
        }
        return view('Admin.notice.notice-edit',compact('obj'));
    }
    public function ajax_get_file(Notice $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Notice();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
