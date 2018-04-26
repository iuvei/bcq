<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\GamestoreCategory;

class GamestoreCategoryController extends Controller
{
    protected $passField = [
        'gname','image','sort','status'
    ];

    public function category_list(Request $request){
        $object = GamestoreCategory::getCategory();
        return view('Admin.gamestore_category.category-list',compact('object'));
    }

    public function category_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'gname' => 'required|max:10',
                'image' => 'required',
                'sort' => 'integer',
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
            $num = GamestoreCategory::count();
            $data['weight'] = pow(2,$num);
            GamestoreCategory::create($data);
            //返回结果
        }
        return view('Admin.gamestore_category.category-add');
    }

    public function category_edit(GamestoreCategory $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'gname' => 'required|max:10',
                'image' => 'required',
                'sort' => 'integer',
                'status' => 'required',
            ]);
            //数据库操作
            $obj->gname = clean(request('cname'));
            $obj->image = request('status');
            $obj->sort = request('sort');
            $obj->status = request('status');
            $obj->save();
            //返回结果
        }
        return view('Admin.gamestore_category.category-edit',compact('obj'));
    }

}
