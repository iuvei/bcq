<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Fall;

class FallController extends Controller
{
    protected $passField = [
        'cid','model','status'
    ];

    public function fall_list(Request $request){
        if($request->isMethod('post')){
            $opt = array();
            if ($request->post('model')){
                $opt['model'] = $request->post('model');
            }
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            if ($sSearch){
                $opt['title'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Fall::getFall(0,10,true,$opt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.fall.fall-list',compact('object'));
    }

    public function fall_ajax_list(Request $request){
        $opt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $opt['title'] = array('like','%'.$sSearch.'%');
        }

        $object = Fall::getFall($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,array());
        $Fall = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Fall['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Fall::getFallCount();
            $Fall['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Fall);

        //dd($object['fall']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function getdata($type,$skip,$limit,$flag,$orOpt,$betweenOpt,$inOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $modelName = "App\\Models\\AdminModels\\".ucfirst($type);
        $model = new $modelName();
        $query = $model->where("status",1)->whereDoesntHave('Fall');

        if ($type == 'business'|| $type == 'platform'){
            $query = $query->where('type',1);
        }
        if (!empty($inOpt)){
            foreach ($inOpt as $k => $v){
                $query = $query->whereIn($k,$v);
            }
        }
        if (!empty($betweenOpt)){
            foreach ($betweenOpt as $k => $v){
                $query = $query->whereBetween($k,$v);
            }
        }
        if (!empty($orOpt)){
            $query = $query->where(function ($query) use($orOpt){
                foreach ($orOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        }

        if ($flag){
            $obj = $query->orderby('id','desc')->get();
        }else{
            $obj = $query->orderby('id','desc')->skip($skip)->limit($limit)->get();
        }


        return $obj;
    }

    public function getdataCount($type){
        $modelName = "App\\Models\\AdminModels\\".ucfirst($type);
        $model = new $modelName();
        $count = $model->where('status',1)->whereDoesntHave('Fall')->count();
        return $count;
    }

    public function fall_add($type,Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }

            $object = $this->getdata($type,0,10,true,$orOpt,$betweenOpt,array());

        }else{
            $object = array();
        }
        return view('Admin.fall.fall-add',compact('object','type'));
    }

    public function fall_ajax_add($type,Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = $this->getdata($type,$request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt,array(),array());
        $Fall = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Fall['iTotalDisplayRecords'] = count($object);
        } else {
            $count = $this->getdataCount($type);
            $Fall['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Fall);

        //dd($object['fall']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function fall_insert($type,Request $request){
        $nidList = explode(',',$request->get('id_list'));
        if ($nidList){
            $inOpt['id'] = $nidList;
            $obj = $this->getdata(ucfirst($type),0,10,false,array(),array(),$inOpt);
        }
        if (ucfirst($type) == 'Trends'){
            $type = 'Trend';
        }
        if (ucfirst($type) == 'Data'){
            $type = 'UserData';
        }

        if ($obj->all()){
            foreach ($obj->all() as $val){


                $data[] = ['title' => $val['title'],'cid' => $val['id'], 'model' => ucfirst($type),'status' => 1,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
            }
            $fallAdmin = new Fall();
            $res = $fallAdmin->insert($data);
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
            $model = new Fall();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
