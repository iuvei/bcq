<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Data;
use App\Models\AdminModels\User;
use App\Models\AdminModels\Fall;
use App\Models\AdminModels\Message;

class DataController extends Controller
{
    protected $category;
    protected $author;
    protected $passField = [
        'uid','title','brief','file','keywords','type','suffix','view','price','sort','status'
    ];

    public function __construct()
    {
        $this->author = User::getUserAuthor();
    }

    public function data_list(Request $request){
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
            $object = Data::getData(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.data.data-list',compact('object'));
    }

    public function data_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['brief'] = array('like','%'.$sSearch.'%');
        }

        $object = Data::getData($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Data::getDataCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }


    public function data_review(Request $request){
        $object = Data::where('status', 0)->get();
        return view('Admin.data.data-list',compact('object'));
    }

    public function data_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'uid' => 'required',
                'title' => 'required|max:40',
                'brief' => 'required|max:200',
                'file' => 'required',
                'view' => 'integer',
                'price' => 'integer',
                'sort' => 'integer',
                'type' => 'required',
                'status' => 'required',
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
            Data::create($data);
            //返回结果
        }
        $author = $this->author;
        return view('Admin.data.data-add',compact('author'));
    }

    public function data_edit(Data $obj){
        $oldStatus = $obj->status;
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'brief' => 'required|max:200',
                'file' => 'required',
                'view' => 'integer',
                'price' => 'integer',
                'sort' => 'integer',
                'type' => 'required',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'brief'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                }
            }
            if($obj->save()){
                if (intval($obj->status) == 1 && intval($oldStatus) == 0){
                    Fall::updateOrCreate(
                        ['title' => $obj->title,'uid' => $obj->uid,'cid' => $obj->id, 'model' => 'UserData','status' => 1],
                        ['updated_at' => date('Y-m-d H:i:s')]
                    );
                    Message::create(
                        ['from' => 1,'to' => $obj->uid,'status' => 1,'content' => "你于产业资源 $obj->created_at 发布的内容，已在".date('Y-m-d H:i:s')." 审核通过，期待你发布更多的产业相关动态。"]
                    );
                }elseif (intval($obj->status) != 1){
                    Fall::where(['cid' => $obj->id])
                        ->where(['model' => 'UserData'])
                        ->update(
                            ['status' => 0]
                        );
                }
            }
            //返回结果
        }
        $obj = $obj->load('files');
        $table = $obj->getTable();
        return view('Admin.data.data-edit',compact('obj','table'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Data();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
