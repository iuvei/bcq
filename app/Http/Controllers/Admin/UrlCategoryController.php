<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\UrlCategory;

class UrlCategoryController extends Controller
{
    protected $passField = [
        'cname','sort','status'
    ];

    public function category_list(Request $request){
        $object = UrlCategory::getCategory('!=',-1,'id');
        return view('Admin.url_category.category-list',compact('object'));
    }

    public function category_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'cname' => 'required|max:10',
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
            UrlCategory::create($data);
            //返回结果
        }
        return view('Admin.url_category.category-add');
    }

    public function category_edit(UrlCategory $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'cname' => 'required|max:10',
                'sort' => 'integer',
                'status' => 'required',
            ]);
            //数据库操作
            $obj->cname = clean(request('cname'));
            $obj->sort = request('sort');
            $obj->status = request('status');
            $obj->save();
            //返回结果
        }
        return view('Admin.url_category.category-edit',compact('obj'));
    }

}
