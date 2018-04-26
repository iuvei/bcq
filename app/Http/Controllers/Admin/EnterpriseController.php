<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Enterprise;

class EnterpriseController extends Controller
{
    protected $passField = [
        'sort','famous','scale','region','view','addip','title','content','logo','url','status'
    ];

    public function enterprise_list(Request $request){
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
            $object = Enterprise::getEnterprise(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.enterprise.enterprise-list',compact('object'));
    }

    public function enterprise_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Enterprise::getEnterprise($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Enterprise = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Enterprise['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Enterprise::getEnterpriseCount();
            $Enterprise['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Enterprise);

        //dd($object['enterprise']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function enterprise_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'sort' => 'integer',
                'scale' => 'required',
                'region' => 'required',
                'view' => 'integer',
                'title' => 'required|max:40',
                'content' => 'required|max:21845',
                'url' => 'nullable|url',
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
            $data['addip'] = $request->getClientIp();;
            Enterprise::create($data);
            //返回结果
        }
        return view('Admin.enterprise.enterprise-add');
    }

    public function enterprise_edit(Enterprise $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'sort' => 'integer',
                'scale' => 'required',
                'region' => 'required',
                'view' => 'integer',
                'title' => 'required|max:40',
                'content' => 'required|max:21845',
                'url' => 'nullable|url',
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
            $obj->addip = request()->getClientIp();;
            $obj->save();
            //返回结果
        }
        return view('Admin.enterprise.enterprise-edit',compact('obj'));
    }
    public function ajax_get_file(Enterprise $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Enterprise();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
