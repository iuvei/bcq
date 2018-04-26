<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Cash;

class CashController extends Controller
{
    protected $category;
    protected $passField = [
        'title','sort','access','games','region','view','addip','url1','url2','url3','url4','mark','mark1','mark2','mark3','mark4','content','logo','status'
    ];

    public function cash_list(Request $request){
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
            $object = Cash::getCash(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.cash.cash-list',compact('object'));
    }

    public function cash_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Cash::getCash($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Cash = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Cash['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Cash::getCashCount();
            $Cash['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Cash);

        //dd($object['cash']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function cash_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'sort' => 'integer',
                'access' => 'required',
                'games' => 'required',
                'region' => 'required',
                'view' => 'integer',
                'url1' => 'nullable|url',
                'url2' => 'nullable|url',
                'url3' => 'nullable|url',
                'url4' => 'nullable|url',
                'mark' => 'required|integer',
                'mark1' => 'required|integer',
                'mark2' => 'required|integer',
                'mark3' => 'required|integer',
                'mark4' => 'required|integer',
                'content' => 'required|max:21845',
                'status' => 'required',
            ]);
            //数据库操作
            $data = [];
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $data[$key] = $val;
                }
            }
            $data['addip'] = $request->getClientIp();
            Cash::create($data);
            //返回结果
        }
        return view('Admin.cash.cash-add');
    }

    public function cash_edit(Cash $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'sort' => 'integer',
                'access' => 'required',
                'games' => 'required',
                'region' => 'required',
                'view' => 'integer',
                'url1' => 'nullable|url',
                'url2' => 'nullable|url',
                'url3' => 'nullable|url',
                'url4' => 'nullable|url',
                'mark' => 'required|integer',
                'mark1' => 'required|integer',
                'mark2' => 'required|integer',
                'mark3' => 'required|integer',
                'mark4' => 'required|integer',
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
            $obj->addip = request()->getClientIp();;
            $obj->save();
            //返回结果
        }
        return view('Admin.cash.cash-edit',compact('obj'));
    }
    public function ajax_get_file(Cash $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Cash();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
