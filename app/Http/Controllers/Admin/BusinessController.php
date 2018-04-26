<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Business;
use App\Models\AdminModels\Bcategory;
use App\Models\AdminModels\User;
use App\Models\AdminModels\Fall;
use App\Models\AdminModels\Message;

class BusinessController extends Controller
{
    protected $category;
    protected $author;
    protected $passField = [
        'uid','type','bid','sort','hot','confirm','money','top','view','validitytime','title','url','pic','content','contactperson','phone','skype','qq','wechat','email','enterprise','logo','brief','personnel','plate','year','scale','status'
    ];

    public function __construct()
    {
        $this->category = Bcategory::getCategory('id');
        $this->author = User::getUserAuthor();
    }

    public function business_list($type,Request $request){
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
            $object = Business::getBusiness(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        $category = Bcategory::getLastCategory($this->category);
        return view('Admin.business.business-list',compact('object','category','type'));
    }

    public function business_ajax_list($type,Request $request){
        $opt = array('type'=>$type);
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Business::getBusiness($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Business::getBusinessCount($type);
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function business_review($type,Request $request){
        $object = Business::where('type', $type)->where('status', 0)->get()->load('bcategory', 'user');
        $category = Bcategory::getLastCategory($this->category);
        return view('Admin.business.business-list',compact('object','category','type'));
    }

    public function business_add($type,Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'uid' => 'required',
                'sbid' => 'required',
                'bid' => 'required',
                'sort' => 'integer',
                'money' => 'integer',
                'view' => 'integer',
                'title' => 'required|max:40',
                'brief' => 'nullable|max:100',
                'content' => 'required|max:21845',
                'status' => 'required',
                'url' => 'nullable|url',
            ]);
            //数据库操作
            $data = [];
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
            Business::create($data);
            //返回结果
        }
        $category = Bcategory::getGroupCategory();
        $author = $this->author;
        return view('Admin.business.business-add',compact('category','type','author'));
    }

    public function business_edit(Business $obj){
        $oldStatus = $obj->status;
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'sbid' => 'required',
                'bid' => 'required',
                'sort' => 'integer',
                'money' => 'integer',
                'view' => 'integer',
                'title' => 'required|max:40',
                'brief' => 'nullable|max:100',
                'content' => 'required|max:21845',
                'status' => 'required',
                'url' => 'nullable|url',
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
                        ['title' => $obj->title,'uid' => $obj->uid,'cid' => $obj->id, 'model' => 'Business','status' => 1],
                        ['updated_at' => date('Y-m-d H:i:s')]
                    );
                    Message::create(
                        ['from' => 1,'to' => $obj->uid,'status' => 1,'content' => "你于供求商讯 $obj->created_at 发布的内容，已在".date('Y-m-d H:i:s')." 审核通过，期待你发布更多的产业相关动态。"]
                    );
                }elseif (intval($obj->status) != 1){
                    Fall::where(['cid' => $obj->id])
                        ->where(['model' => 'Business'])
                        ->update(
                            ['status' => 0]
                        );
                }
            }
            //返回结果
        }
        $category = Bcategory::getGroupCategory();
        $obj = $obj->load('bcategory');
        $table = $obj->getTable();
        return view('Admin.business.business-edit',compact('obj','table','category'));
    }

    public function type_change(Business $obj){
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

    public function ajax_get_file(Business $obj){
        return '['.trim(trim($obj->pic,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Business();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
