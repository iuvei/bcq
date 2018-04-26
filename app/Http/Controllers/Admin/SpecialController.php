<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Special;

class SpecialController extends Controller
{
    protected $passField = [
        'hot','sort','title','image','content','status'
    ];

    public function special_list(Request $request){
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
            $object = Special::getSpecial(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.special.special-list',compact('object'));
    }

    public function special_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Special::getSpecial($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Special = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Special['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Special::getSpecialCount();
            $Special['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Special);

        //dd($object['special']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function special_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'hot' => 'integer',
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
            Special::create($data);
            //返回结果
        }
        return view('Admin.special.special-add');
    }

    public function special_edit(Special $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'hot' => 'integer',
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
        return view('Admin.special.special-edit',compact('obj'));
    }
    public function ajax_get_file(Special $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Special();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
