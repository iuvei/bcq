<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use Closure;
use App\Models\DownloadRecord;
use App\Models\UserData;
class MyDataPageController extends Controller //我的资料页面
{
	protected $user;

	protected $myDataOpt;

    public function __construct(Request $request){

        $this->middleware(function ($request,Closure $next){

            $user_info = get_user_info();

            if ($user_info['code'] == 1){

                $this->user = $user_info['user'];
                //登陆后才显示关注状态
                $this->myDataOpt = ['field'=>['View','Comment'],'file_info'=>1,'uid'=>$this->user->id];

            }else{
            	echo json_encode(['code'=>0,'msg'=>'请登录您的账号']);
            	die;
            }

                return $next($request);
        });
    }


	public function render(){

		$adsList = AdvertisingSystem::getAds(config('etc.mydata.page_id'));//获取该页所有广告位广告信息

		$mydata['my_upload'] = $this->getList('UserData',0,config('etc.mydata.my_upload.render_limit'),$this->myDataOpt);

		$my_download = DownloadRecord::user_download_record($this->user->id,0,config('etc.mydata.my_download.render_limit'),1);

		$mydata['my_download'] = $this->getList('UserData',0,10000,['field'=>['View','Comment'],'file_info'=>1,'id'=>$my_download,'is_comment'=>$this->user->id]);

		$render = [
			'adsList'=>$adsList,
			'mydata'=>$mydata
		];

		echo json_encode($render);
	}

	public function get_count(){

		$user['id'] = $this->user->id;

		$user['image'] = $this->user->image;

		$user['username'] = name_filter($this->user->username);

		$user['price'] = $this->user->price;	

		$mydata['user'] = $user;

		$mydata['upload'] = UserData::upload_count($this->user->id);

		$mydata['download'] = DownloadRecord::download_count($this->user->id,1);

		echo json_encode(['code'=>1,'mydata'=>$mydata]);
	}

	public function getUploadList(Request $request){

		$page = $request->input('page');

        $page_info = page_helper($page,config('etc.mydata.my_upload.render_limit'),config('etc.mydata.my_upload.limit'));

        $userDataList = $this->getList('UserData',$page_info['skip'],$page_info['limit'],$this->myDataOpt);

        echo json_encode($userDataList);  

	}

	public function getDownloadList(Request $request){

		$page = $request->input('page');

        $page_info = page_helper($page,config('etc.mydata.my_download.render_limit'),config('etc.mydata.my_download.limit'));

		$my_download = DownloadRecord::user_download_record($this->user->id,$page_info['skip'],$page_info['limit'],1);

		$mydata = $this->getList('UserData',0,10000,['field'=>['View','Comment'],'file_info'=>1,'id'=>$my_download]);

        echo json_encode($mydata);  

	}

	public function delete(Request $request){//删除我上传的

		$id = $request->input('id');

		UserData::deleteUserData($id);

		echo json_encode(['code'=>1,'msg'=>'已删除']);
	}

	public function edit(Request $request){//编辑我上传的

		$id = $request->input('id');

		$data_detail = UserData::getEdits($id,$this->user->id);	

		echo json_encode($data_detail);			
	}

	public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }
}