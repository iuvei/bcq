<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Show;

class ShowController extends Controller
{
    protected $passField = [
        'sort','famous','starttime','endtime','view','title','short','sponsor','address','image','url','content','status'
    ];

    public function show_list(Request $request){
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
            $object = Show::getShow(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.show.show-list',compact('object'));
    }

    public function show_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Show::getShow($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Show = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Show['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Show::getShowCount();
            $Show['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Show);

        //dd($object['show']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function show_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'sort' => 'integer',
                'famous' => 'required',
                'view' => 'integer',
                'title' => 'required|max:40',
                'short' => 'required|max:100',
                'sponsor' => 'required|max:200',
                'address' => 'required|max:200',
                'url' => 'required|url',
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
                    if ($key == 'starttime' || $key == 'endtime'){
                        $data[$key] = strtotime($val);
                    }else{
                        $data[$key] = $val;
                    }
                }
            }
            Show::create($data);
            //返回结果
        }
        return view('Admin.show.show-add');
    }

    public function show_edit(Show $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'sort' => 'integer',
                'famous' => 'required',
                'view' => 'integer',
                'title' => 'required|max:40',
                'short' => 'required|max:100',
                'sponsor' => 'required|max:200',
                'address' => 'required|max:200',
                'url' => 'required|url',
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
                    if ($key == 'starttime' || $key == 'endtime'){
                        $obj->$key = strtotime($val);
                    }else{
                        $obj->$key = $val;
                    }
                }
            }
            $obj->save();
            //返回结果
        }
        return view('Admin.show.show-edit',compact('obj'));
    }
    public function ajax_get_file(Show $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Show();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
