<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Micro;
use App\Models\AdminModels\Fall;

class MicroController extends Controller
{

    protected $passField = [
        'uid','utype','content','image','sort','view','top','status'
    ];

    public function micro_list(Request $request){
        if($request->isMethod('post')){
            $opt = array(
                'status' => array('!=',-1)
            );

            if ($request->post('cid')){
                $opt['utype'] = $request->post('utype');
            }

            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            if ($sSearch){
                $opt['content'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Micro::getMicro(0,10,$opt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.micro.micro-list',compact('object'));
    }

    public function micro_ajax_list(Request $request){
        $opt = array(
            'status' => array('!=',-1)
        );

        $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
        if ($sSearch){
            $opt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Micro::getMicro($request->get('iDisplayStart'),$request->get('iDisplayLength'),$opt);
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Micro::getMicroCount('!=',-1);
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function micro_edit(Micro $obj){
        $oldStatus = $obj->status;
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'utype' => 'required',
                'content' => 'required|max:21845',
                'sort' => 'integer',
                'view' => 'integer',
                'top' => 'integer',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    if ($key == 'image'){
                        $obj->$key = '['.$val.']';
                    }else{
                        $obj->$key = $val;
                    }
                }
            }
            if($obj->save()){
                if (intval($obj->status) != 1){
                    Fall::where(['cid' => $obj->id])
                        ->where(['model' => 'Micro'])
                        ->update(
                            ['status' => 0]
                        );
                }
            }
            //返回结果
        }
        $table = $obj->getTable();
        return view('Admin.micro.micro-edit',compact('obj','table'));
    }


    public function ajax_get_file(Micro $obj){
        return '['.trim(trim($obj->image,'['),']').']';
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Micro();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
