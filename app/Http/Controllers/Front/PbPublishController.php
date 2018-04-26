<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Platform;
use DisplaySystem;
use FileSystem;
use Closure;
class PbPublishController extends Controller
{
	private $uid;

    private $platform_obj;

    private $business_obj;

    public function __construct(Request $request)
    {

        $this->platform_obj = new Platform();

		$this->business_obj = new Business();

        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;

            }
            return $next($request);
        });
    }

    public function get_platform_opt(){

    	$settlement = config('base.settlement');

    	$games = config('base.games');

    	echo json_encode(['settlement'=>$settlement,'games'=>$games]); 

    }

    public function get_business_opt(){

        //种类分类
        $catList = $this->getList('Bcategory',0,10000,[])->groupBy('fid');

        echo json_encode($catList);

    }


    public function platform_publish(Request $request){

    	$data = $request->input('data');

        if (! $this->uid) {
            echo json_encode(['code'=>0,'msg'=>'请先登录账号']);
            die;
        }

        $id = $request->input('id');
       
        if ($id) {

            $this->platform_obj = $this->platform_obj->where('id',$id)->first();
        
        }

    	try {

			$this->platform_obj->type = $request->input('type');

			$this->platform_obj->uid = $this->uid;

			$this->platform_obj->title = clean($data['title']);

			$this->platform_obj->games = array_sum($data['plat']);
			
			$this->platform_obj->pic = json_encode(array_filter($data['picture']));

			$this->platform_obj->content = $data['desc'];

			$this->platform_obj->settlement = $data['payment'];

			$this->platform_obj->contactperson = clean($data['contact']);

			$this->platform_obj->phone = clean($data['phone']);

			$this->platform_obj->qq = clean($data['qq']);

			$this->platform_obj->skype = clean($data['skype']);

			$this->platform_obj->wechat = clean($data['weixin']);
            
            $this->platform_obj->status = 0;

            isset($data['url'])?$this->platform_obj->url = clean($data['url']):$this->platform_obj->url='';
			
            $this->platform_obj->save();

    	}catch(Exception $e){

    		echo json_encode($e->getMessage());

    		die;
    	}

    	echo json_encode(['code'=>1,'msg'=>'success']);

    }

    public function business_publish(Request $request){

        $data = $request->input('data');

        $type = $request->input('type');

        $id = $request->input('id');

        if (! $this->uid) {
            echo json_encode(['code'=>0,'msg'=>'请先登录账号']);
            die;
        }

        if ($id) {

            $this->business_obj = $this->business_obj->where('id',$id)->first();
        
        }

        try{

            $this->business_obj->uid = $this->uid;

            $this->business_obj->type = $type;

            $this->business_obj->title = clean($data['title']);

            $this->business_obj->content = $data['desc'];

            $this->business_obj->contactperson = clean($data['contact']);

            $this->business_obj->bid = $data['payment'];

            if (!isset($this->business_obj->bid)) {

                echo json_encode(['code'=>0,'msg'=>'请选择服务类型']);

                die;
            }

            $this->business_obj->phone = clean($data['phone']);

            $this->business_obj->qq = clean($data['qq']);

            $this->business_obj->skype = clean($data['skype']);

            $this->business_obj->wechat = clean($data['weixin']);

            $this->business_obj->pic = isset($data['picture'])?json_encode(array_filter($data['picture'])):'';

            $this->business_obj->status = 0;

            if ($type == 1) {

                $this->business_obj->url = clean($data['url']);
            }

            $this->business_obj->save();

        }catch(Exception $e){

            echo json_encode($e->getMessage());

            die;

        }

        echo json_encode(['code'=>1,'msg'=>'success']);

    }

    public function uploadPicture(Request $request){

        if (!isset($this->uid)) {
            echo json_encode(['code'=>0,'msg'=>' 请先登录账号']);
            die;
        }

        $dir = 'trade/'.$this->uid;

        $picture = $request->input('picture');

        $path_ret = FileSystem::uploadPublicFileBase64($picture,$dir);

        if (!$path_ret['code']) {
            echo json_encode(['code'=>0,'msg'=>'上传图片失败']);
            die;
        }

        echo json_encode($path_ret);
    }



    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

    public function getDetail(Request $request){

        $model = $request->input('model');

        $uid = $this->uid;        

        $id = $request->input('id');

        if (!$this->uid||!$model||!$id) {
        
            echo json_encode([]);

            die;
        
        }

        $obj = get_model_obj($model);

        $ret = $obj->getDetail($id,$uid);

        echo json_encode($ret);
    }
}
