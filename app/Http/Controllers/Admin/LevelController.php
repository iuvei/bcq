<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Level;

class LevelController extends Controller
{
    protected $passField = [
        'title','min','max','status'
    ];

    public function level_list(){
        $object = Level::getLevel('created_at');
        return view('Admin.level.level-list',compact('object'));
    }

    public function level_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'min' => 'required|integer',
                'max' => 'required|integer',
                'status' => 'required',
            ]);
            //数据库操作
            $data = [];
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    $data[$key] = $val;
                }
            }
            Level::create($data);
            //返回结果
        }
        return view('Admin.level.level-add');
    }

    public function level_edit(Level $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'min' => 'required|integer',
                'max' => 'required|integer',
                'status' => 'required',
            ]);
            //数据库操作
            $obj->title = clean(request('title'));
            $obj->min = request('min');
            $obj->max = request('max');
            $obj->status = request('status');
            $obj->save();
            //返回结果
        }
        return view('Admin.level.level-edit',compact('obj'));
    }

}