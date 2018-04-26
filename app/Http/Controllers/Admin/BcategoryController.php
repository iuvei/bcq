<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Bcategory;

class BcategoryController extends Controller
{
    protected $category;
    protected $passField = [
        'fid','cname','sort','recommend','status'
    ];

    public function __construct()
    {
        $this->category = Bcategory::getCategory('id');
    }

    public function category_list(Request $request){
        $object = Bcategory::getCategory('id');
        return view('Admin.bcategory.bcategory-list',compact('object'));
    }

    public function category_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'fid' => 'required',
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
            Bcategory::create($data);
            //返回结果
        }
        $fcategory = Bcategory::getFirstCategory($this->category);
        return view('Admin.bcategory.bcategory-add',compact('fcategory'));
    }

    public function category_edit(Bcategory $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'cname' => 'required|max:10',
                'sort' => 'integer',
                'status' => 'required',
            ]);
            //数据库操作
            $obj->fid = request('fid');
            $obj->cname = clean(request('cname'));
            $obj->sort = request('sort');
            $obj->status = request('status');
            $obj->save();
            //返回结果
        }
        $fcategory = Bcategory::getFirstCategory($this->category);
        return view('Admin.bcategory.bcategory-edit',compact('obj','fcategory'));
    }

}
