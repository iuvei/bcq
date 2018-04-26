<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Key;
use Illuminate\Support\Facades\Redis;

class KeyController extends Controller
{
    protected $category;
    protected $passField = [
        'keywords','view'
    ];
    protected $author;

    public function key_list(Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $opt = array();
            if ($sSearch){
                $opt['keywords'] = array('like','%'.$sSearch.'%');
            }
            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Key::getKeys(0,10,true,$opt,$betweenOpt);
        }else{
            $object = array();
        }
        $category = $this->category;
        return view('Admin.key.key-list',compact('object','category'));
    }

    public function key_ajax_list(Request $request){
        $opt = array();
        if ($request->get('sSearch')) {
            $sSearch = $request->get('sSearch') ? $request->get('sSearch') : '';
            $opt['keywords'] = array('like', '%' . $sSearch . '%');
        }

        $object = Key::getKeys($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Key::getKeyCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

    }

    public function key_edit(Key $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'status' => 'required',
            ]);
            //数据库操作

            $obj->status = request()->get('status');
            Redis::set('disable_new_keyword_flag',1);
            $obj->save();
            //返回结果
        }
        return view('Admin.key.key-edit',compact('obj'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Key();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            Redis::set('disable_new_keyword_flag',1);
            return $return;
        }
    }

}
