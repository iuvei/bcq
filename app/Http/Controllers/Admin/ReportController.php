<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Report;

class ReportController extends Controller
{
    protected $passField = [
        'title','brief','content','image','file','suffix','view','price','sort','status',
    ];

    public function report_list(Request $request){
        if($request->isMethod('post')){
            $opt = array();
            if ($request->post('bid')){
                $opt['bid'] = $request->post('bid');
            }

            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
                $orOpt['brief'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Report::getReport(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.report.report-list',compact('object'));
    }

    public function report_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['brief'] = array('like','%'.$sSearch.'%');
        }

        $object = Report::getReport($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Report::getReportCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function report_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'brief' => 'required|max:200',
                'content' => 'required|max:21845',
                'view' => 'integer',
                'price' => 'integer',
                'sort' => 'integer',
                'file' => 'required',
                'status' => 'required',
            ]);
            //数据库操作
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'brief' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    if ($key == 'pic'){
                        $data[$key] = '['.$val.']';
                    }else{
                        $data[$key] = $val;
                    }
                }
            }
            Report::create($data);
            //返回结果
        }
        return view('Admin.report.report-add');
    }

    public function report_edit(Report $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'brief' => 'required|max:200',
                'content' => 'required|max:21845',
                'view' => 'integer',
                'price' => 'integer',
                'sort' => 'integer',
                'file' => 'required',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'brief' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                    if ($key == 'pic'){
                        $obj->$key = '['.$val.']';
                    }else{
                        $obj->$key = $val;
                    }
                }
            }
            $obj->save();
            //返回结果
        }
        $obj = $obj->load('files');
        return view('Admin.report.report-edit',compact('obj'));
    }
    public function ajax_get_file(Report $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Report();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
