<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $passField = [
        'name','password','group','regip','lastloginip','remember_token','status'
    ];

    public function admin_list(Request $request){
        if($request->isMethod('post')){
            $opt = array(
                'status' => array('!=',-1)
            );
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['name'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
        if ($request->post('datemin') && $request->post('datemax')){
            $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
        }
            $object = Admin::getAdmin(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }

        return view('Admin.admin.admin-list',compact('object'));
    }

    public function admin_ajax_list(Request $request){
        $opt = array(
            'status' => array('!=',-1)
        );

        $orOpt = array();
        if ($request->get('sSearch')){
            $orOpt['name'] = array('like','%'.$sSearch.'%');
        }

        $object = Admin::getAdmin($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),

        );
        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Admin::getAdminCount('!=',-1);
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.admin.admin-list', compact('admin'));
    }

    public function admin_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'name' => 'required|unique:admin',
                'password' => 'required|min:8',
                'status' => 'required',
            ]);

            //数据库操作
            $ip = $request->getClientIp();
            $data = array('regip'=>$ip,'lastloginip'=>$ip);
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if ($key == 'password'){
                        $val = Hash::make($val);
                    }
                    $data[$key] = $val;
                }
            }
            $data['regip'] = request()->getClientIp();
            $data['lastloginip'] = request()->getClientIp();
            Admin::create($data);
            //返回结果
        }

        return view('Admin.admin.admin-add');
    }

    public function admin_edit(Admin $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'name' => $obj->name==request()->get('name')?'required':'required|unique:admin',
                'password' => 'required|min:8',
                'status' => 'required',
            ]);
            //数据库操作
            $obj->lastloginip = request()->getClientIp();
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if ($key == 'password'){
                        $val = Hash::make($val);
                    }
                    $obj->$key = $val;
                }
            }
            $obj->regip = request()->getClientIp();
            $obj->lastloginip = request()->getClientIp();
            $obj->save();
            //返回结果
        }
        return view('Admin.admin.admin-edit',compact('obj'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Admin();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }
}