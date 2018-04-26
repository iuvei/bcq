<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Platform;
use App\Models\AdminModels\User;
use App\Models\AdminModels\Fall;
use App\Models\AdminModels\Message;

class PlatformController extends Controller
{
    protected $author;
    protected $passField = [
        'brief','confirm','content','contactperson','email','enterprise','hot','logo','money','personnel','phone','pic','plate','qq','skype','sort','status','title','top','type','url','validitytime','view','wechat','gid','rate','games','settlement'
    ];

    public function __construct()
    {
        $this->author = User::getUserAuthor();
    }

    public function platform_list($type,Request $request){
        if($request->isMethod('post')){
            $opt = array('type'=>$type);
            if ($request->post('bid')){
                $opt['bid'] = $request->post('bid');
            }

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
            $object = Platform::getPlatform(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.platform.platform-list',compact('object','type'));
    }

    public function platform_ajax_list($type,Request $request){
        $opt = array('type'=>$type);
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Platform::getPlatform($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Platform::getPlatformCount($type);
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function platform_review($type,Request $request){
        $object = Platform::where('type',$type)->where('status',0)->get()->load('user');
        return view('Admin.platform.platform-list',compact('object','type'));
    }

    public function platform_add($type,Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'brief' => 'max:100',
                'content' => 'required|max:21845',
                'money' => 'integer',
                'sort' => 'integer',
                'status' => 'required',
                'title' => 'required|max:40',
                'top' => 'integer',
                'url' => 'nullable|url',
                'view' => 'integer',
                'games' => 'required',
                'settlement' => 'required',
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
                    }else if ($key == 'validitytime'){
                        $data[$key] = strtotime($val);
                    }else{
                        $data[$key] = $val;
                    }
                }
            }
            $data['type'] = $type;
            Platform::create($data);
            //返回结果
        }
        $author = $this->author;
        return view('Admin.platform.platform-add',compact('type','author'));
    }

    public function platform_edit(Platform $obj){
        $oldStatus = $obj->status;
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'brief' => 'max:100',
                'content' => 'required|max:21845',
                'money' => 'integer',
                'sort' => 'integer',
                'status' => 'required',
                'title' => 'required|max:40',
                'top' => 'integer',
                'url' => 'nullable|url',
                'view' => 'integer',
                'games' => 'required',
                'settlement' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'brief' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    if ($key == 'pic'){
                        $obj->$key = '['.$val.']';
                    }else if ($key == 'validitytime'){
                        $obj->$key = strtotime($val);
                    }else{
                        $obj->$key = $val;
                    }
                }
            }
            if($obj->save()){
                if (intval($obj->status) == 1 && intval($oldStatus) == 0){
                    Fall::updateOrCreate(
                        ['title' => $obj->title,'uid' => $obj->uid,'cid' => $obj->id, 'model' => 'Platform','status' => 1],
                        ['updated_at' => date('Y-m-d H:i:s')]
                    );
                    Message::create(
                        ['from' => 1,'to' => $obj->uid,'status' => 1,'content' => "你于代理招商 $obj->created_at 发布的内容，已在".date('Y-m-d H:i:s')." 审核通过，期待你发布更多的产业相关动态。"]
                    );
                }elseif (intval($obj->status) != 1){
                    Fall::where(['cid' => $obj->id])
                        ->where(['model' => 'Platform'])
                        ->update(
                            ['status' => 0]
                        );
                }
            }
            //返回结果
        }
        $table = $obj->getTable();
        return view('Admin.platform.platform-edit',compact('obj','table'));
    }

    public function type_change(Platform $obj){
        if(intval($obj->type) == 1){
            $obj-> type = 2;
        }else{
            $obj-> type = 1;
        }
        $res = $obj->save();

        $return['code'] = 0;
        if ($res){
            $return['code'] = 200;
        }
        echo json_encode($return);
    }

    public function ajax_get_file(Platform $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Platform();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
