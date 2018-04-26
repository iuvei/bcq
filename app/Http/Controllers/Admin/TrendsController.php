<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Trends;
use App\Models\AdminModels\User;
use App\Models\AdminModels\Fall;
use App\Models\AdminModels\Message;

class TrendsController extends Controller
{
    protected $passField = [
        'title','content','product_url','sort','view','uid','type','status'
    ];
    protected $author;

    public function __construct()
    {
        $this->author = User::getUserAuthor();
    }

    public function trends_list(Request $request){
        if($request->isMethod('post')){
            $opt = array(
                'status' => array('!=',-1)
            );

            if ($request->post('cid')){
                $opt['cid'] = $request->post('cid');
            }

            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
                $orOpt['content'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Trends::getTrends(0,10,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.trends.trends-list',compact('object'));
    }

    public function trends_ajax_list(Request $request){
        $opt = array(
            'status' => array('!=',-1)
        );

        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = Trends::getTrends($request->get('iDisplayStart'),$request->get('iDisplayLength'),$opt,$orOpt);
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Trends::getTrendsCount('!=',-1);
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function trends_review(Request $request){
        $object = Trends::where('status', 0)->get();
        foreach ($object as $key => $val){
            $object[$key]['type_name'] = ' ';
            foreach (config('base.trendsType') as $k => $v){
                if ($val['type'] & $k){
                    $object[$key]['type_name'] .= $v.' ';
                }
            }
        }
        return view('Admin.trends.trends-list',compact('object'));
    }

    public function trends_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'content' => 'required|max:21845',
                'product_url' => 'required|url',
                'sort' => 'integer',
                'view' => 'integer',
                'type' => 'required',
                'status' => 'required',
            ]);

            //数据库操作
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $data[$key] = $val;
                }
            }
            Trends::create($data);
            //返回结果
        }
        $author = $this->author;
        return view('Admin.trends.trends-add',compact('author'));
    }

    public function trends_edit(Trends $obj){
        $oldStatus = $obj->status;
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'content' => 'required|max:21845',
                'product_url' => 'required|url',
                'sort' => 'integer',
                'view' => 'integer',
                'type' => 'required',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                }
            }
            if($obj->save()){
                if (intval($obj->status) == 1 && intval($oldStatus) == 0){
                    Fall::updateOrCreate(
                        ['title' => $obj->title,'uid' => $obj->uid,'cid' => $obj->id, 'model' => 'Trend','status' => 1],
                        ['updated_at' => date('Y-m-d H:i:s')]
                    );
                    Message::create(
                        ['from' => 1,'to' => $obj->uid,'status' => 1,'content' => "你于产品动态 $obj->created_at 发布的内容，已在".date('Y-m-d H:i:s')." 审核通过，期待你发布更多的产业相关动态。"]
                    );
                }elseif (intval($obj->status) != 1){
                    Fall::where(['cid' => $obj->id])
                        ->where(['model' => 'Trend'])
                        ->update(
                            ['status' => 0]
                        );
                }
            }
            //返回结果
        }
        $table = $obj->getTable();
        return view('Admin.trends.trends-edit',compact('obj','table'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Trends();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
