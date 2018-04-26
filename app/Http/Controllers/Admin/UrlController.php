<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Url;
use App\Models\AdminModels\UrlCategory;

class UrlController extends Controller
{
    protected $passField = [
        'ucid','title','url','sort','status'
    ];
    protected $category;

    public function __construct()
    {
        $this->category = UrlCategory::getCategory('!=',-1,'created_at');
    }

    public function url_list(){
        $object = Url::getUrl('sort');
        return view('Admin.url.url-list',compact('object'));
    }

    public function url_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'ucid' => 'required',
                'title' => 'required|max:40',
                'url' => 'required|url',
                'sort' => 'integer',
                'status' => 'required',
            ]);
            //数据库操作
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $url[$key] = $val;
                }
            }
            Url::create($url);
            //返回结果
        }
        $category = $this->category;
        return view('Admin.url.url-add',compact('category'));
    }

    public function url_edit(Url $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'ucid' => 'required',
                'title' => 'required|max:40',
                'url' => 'required|url',
                'sort' => 'integer',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                }
            }
            $obj->save();
            //返回结果
        }
        $category = $this->category;
        return view('Admin.url.url-edit',compact('obj','category'));
    }

}