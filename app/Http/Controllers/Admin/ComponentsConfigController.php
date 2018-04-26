<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\ComponentsConfig;

class ComponentsConfigController extends Controller
{
    protected $passField = [
        'pid','cid','title','sort','status'
    ];

    public function components_config_list(){
        $object = ComponentsConfig::getComponentsConfig('created_at');
        return view('Admin.components_config.components_config-list',compact('object'));
    }

    public function components_config_edit(ComponentsConfig $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'sort' => 'integer',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    $obj->$key = $val;
                }
            }
            $obj->save();
            //返回结果
        }
        return view('Admin.components_config.components_config-edit',compact('obj'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new ComponentsConfig();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }
}