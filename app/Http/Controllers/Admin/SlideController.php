<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Slide;

class SlideController extends Controller
{
    protected $passField = [
        'title','brief','slide_id','image','slide_type','sort','url','type','status'
    ];

    public function slide_list(Request $request){
        if($request->isMethod('post')){
            $opt = array();
            if ($request->post('slide_type')){
                $opt['slide_type'] = $request->post('slide_type');
            }
            if ($request->post('type')){
                $opt['type'] = $request->post('type');
            }

            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            if ($sSearch){
                $opt['title'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Slide::getSlide(0,10,true,$opt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.slide.slide-list',compact('object'));
    }

    public function slide_ajax_list(Request $request){
        $opt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $opt['title'] = array('like','%'.$sSearch.'%');
        }

        $object = Slide::getSlide($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,array());
        $Slide = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Slide['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Slide::getSlideCount();
            $Slide['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Slide);

        //dd($object['slide']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function getdata($type,$skip,$limit,$flag,$orOpt,$betweenOpt,$inOpt){
        if (empty($limit)){
            return [];
        }
        if (!isset($skip)){
            $skip = 0;
        }
        $modelName = "App\\Models\\AdminModels\\".ucfirst($type);
        $model = new $modelName();
        $query = $model->where('status',1)->whereDoesntHave('slide', function ($query) {
            $query->whereIn('slide.status',[0,1]);
        });
        if ($type == 'business'|| $type == 'platform'){
                $query = $query->where('type',1);
        }
        if (!empty($inOpt)){
            foreach ($inOpt as $k => $v){
                $query = $query->whereIn($k,$v);
            }
        }
        if (!empty($betweenOpt)){
            foreach ($betweenOpt as $k => $v){
                $query = $query->whereBetween($k,$v);
            }
        }
        if (!empty($orOpt)){
            $query = $query->where(function ($query) use($orOpt){
                foreach ($orOpt as $k => $v){
                    if(is_array($v) && $v[1]){
                        $query->orWhere($k,$v[0],$v[1]);
                    }elseif(!is_array($v) && $v){
                        $query->orWhere($k,$v);
                    }
                }
            });
        }

        if ($flag){
            $obj = $query->orderby('id','desc')->get();
        }else{
            $obj = $query->orderby('id','desc')->skip($skip)->limit($limit)->get();
        }


        return $obj;
    }

    public function getdataCount($type){
        $modelName = "App\\Models\\AdminModels\\".ucfirst($type);
        $model = new $modelName();
        $count = $model->where('status',1)->whereDoesntHave('slide', function ($query) {
            $query->whereIn('slide.status',[0,1]);
        })->count();
        return $count;
    }

    public function slide_add($type,Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }

            $object = $this->getdata($type,0,10,true,$orOpt,$betweenOpt,array());

        }else{
            $object = array();
        }
        return view('Admin.slide.slide-add',compact('object','type'));
    }

    public function slide_ajax_add($type,Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = $this->getdata($type,$request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt,array(),array());
        $Slide = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Slide['iTotalDisplayRecords'] = count($object);
        } else {
            $count = $this->getdataCount($type);
            $Slide['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Slide);

        //dd($object['slide']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function slide_insert($type,Request $request){
        $nidList = explode(',',$request->get('id_list'));
        if ($nidList){
            $inOpt['id'] = $nidList;
            $obj = $this->getdata($type,0,10,false,array(),array(),$inOpt);
        }

        if ($obj->all()){
            foreach ($obj->all() as $val){
                switch($type)
                {
                    case 'news':
                        $url = '/news/newspage/'.$val['id'];
                        break;
                    case 'report':
                        $url = '/news/reportDetail/'.$val['id'];
                        break;
                    case 'business':
                        $url = '/trade/BusinessDetail/'.$val['id'];
                        break;
                    case 'platform':
                        $url = '/trade/PlatformDetail/'.$val['id'];
                        break;
                    case 'notice':
                        $url = '/notice/'.$val['id'];
                        break;
                    case 'data':
                        $url = '/userdata/UserDataDetail/'.$val['id'];
                        break;
                    case 'banner':
                        $url = '/banner/'.$val['url'];
                        break;
                }


                $data[] = ['slide_id' => $val['id'],'title' => str_replace(config('base.find'),config('base.replace'),$val['title']) , 'brief' => mb_strlen($val['brief']) >= 50 ? str_replace(config('base.find'),config('base.replace'),mb_substr($val['brief'],0,46)).'...' : str_replace(config('base.find'),config('base.replace'),$val['brief']) , 'slide_type' => $type,'url' => $url,'type' => 1,'status' => 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
            }
            $slideAdmin = new Slide();
            $res = $slideAdmin->insert($data);
        }else{
            $res = array();
        }

        if($res){
            $return['code'] = 1;
        }else{
            $return['code'] = 0;
        }
        return json_encode($return);
    }

    public function slide_edit(Slide $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'brief' => 'required|max:50',
                'url' => 'required',
                'sort' => 'integer',
                'type' => 'required',
                'image' => 'required',
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
        return view('Admin.slide.slide-edit',compact('obj'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Slide();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
