<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminModels\GamestoreCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Gamestore;
use App\Models\AdminModels\GamestoreCO;

class GamestoreController extends Controller
{
    protected $passField = [
        'cid','title','brief','logo','url','sort','money','access_point','status','weight'
    ];

    protected $category;

    public function __construct(){

        $this->category = GamestoreCategory::select('id','weight','gname')->where('status',1)->get();

    }

    public function gamestore_list(Request $request){
        if($request->isMethod('post')){
            $opt = array();

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
            $object = Gamestore::getGamestore(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.gamestore.gamestore-list',compact('object'));
    }

    public function gamestore_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['brief'] = array('like','%'.$sSearch.'%');
        }

        $object = Gamestore::getGamestore($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Gamestore = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Gamestore['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Gamestore::getGamestoreCount();
            $Gamestore['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Gamestore);

        //dd($object['gamestore']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function gamestore_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'brief' => 'required|max:200',
                'url' => 'required|url',
                'sort' => 'integer',
                'money' => 'required',
                'access_point' => 'required|integer',
                'status' => 'required',
                'weight' => 'required',
            ]);
            //数据库操作
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'brief'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $data[$key] = $val;
                }
            }
            $res = Gamestore::create($data);
            if ($res){
                $oc_data = [];
                foreach ($this->category as $key => $val){
                    if ($data['weight'] & $val->weight){
                        $oc_data[] = ['gid' => $res->id,'cid' => $val->id,'created_at' => date('Y-m-d H:i:s',time()),'updated_at' => date('Y-m-d H:i:s',time()) ];
                    }
                }
                $GCO = new GamestoreCO();
                $GCO->insert($oc_data);
            }
            //返回结果
        }
        $category = $this->category;
        return view('Admin.gamestore.gamestore-add',compact('category'));
    }

    public function gamestore_edit(Gamestore $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'brief' => 'required|max:200',
                'url' => 'required|url',
                'sort' => 'integer',
                'money' => 'required',
                'access_point' => 'required|integer',
                'status' => 'required',
                'weight' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'brief'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                }
            }
            $res = $obj->save();
            $GCO = new GamestoreCO();
            if ($res && intval($obj->status)){
                $oc_data = [];
                $update_ids = [];
                $gco_res = GamestoreCO::where('gid',$obj->id)->whereIn('status',[0,1])->select('cid')->get()->toArray();
                $cids = array_column($gco_res, 'cid');

                foreach ($this->category as $key => $val){
                    if (!in_array($val->id,$cids) && $obj->weight & $val->weight){
                        $oc_data[] = ['gid' => $obj->id,'cid' => $val->id,'created_at' => date('Y-m-d H:i:s',time()),'updated_at' => date('Y-m-d H:i:s',time()) ];
                    }elseif(in_array($val->id,$cids) && $obj->weight & $val->weight) {
                        $GCO->where('gid',$obj->id)->where('cid',$val->id)->update(['status' => 1]);
                    }else{
                        $GCO->where('gid',$obj->id)->where('cid',$val->id)->update(['status' => 0]);
                    }
                }
                $GCO->insert($oc_data);
            }elseif ($res && !intval($obj->status)){
                $GCO->where('gid',$obj->id)->update(['status' => 0]);
            }
            //返回结果
        }
        $category = $this->category;
        return view('Admin.gamestore.gamestore-edit',compact('obj','category'));
    }

    public function ajax_get_file(Gamestore $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Gamestore();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }

    public function gamestore_co_list($gid){
        $object = GamestoreCO::getGamestoreCOList($gid);
        return view('Admin.gamestore.gamestore_co-list',compact('object'));
    }

    public function gamestore_co_edit(GamestoreCo $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'sort' => 'integer',
            ]);
            //数据库操作
            $obj->sort = request()->get('sort');
            $res = $obj->save();
            //返回结果
        }
        return view('Admin.gamestore.gamestore_co-edit',compact('obj'));
    }

}
