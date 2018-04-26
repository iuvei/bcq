<?php

namespace App\Http\Controllers\Front\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsPublish;
use App\Models\QuestionPublish;
use App\Models\BusinessPublish;
use App\Models\PlatformPublish;
use App\Models\UserDataPublish;
class UserPublishController extends UserCenterController
{

	public function render(){

		$publish['MicroPublish'] = $this->get_publish_list('Micro',$this->user_obj->id,0,config('etc.user_center.publish.render_limit'));

		$publish['NewsPublish'] = $this->get_publish_list('NewsPublish',$this->user_obj->id,0,config('etc.user_center.publish.render_limit'));

		$publish['QuestionPublish'] = $this->get_publish_list('QuestionPublish',$this->user_obj->id,0,config('etc.user_center.publish.render_limit'));

		$publish['BusinessPublish'] = $this->get_publish_list('BusinessPublish',$this->user_obj->id,0,config('etc.user_center.publish.render_limit'));

		$publish['PlatformPublish'] = $this->get_publish_list('PlatformPublish',$this->user_obj->id,0,config('etc.user_center.publish.render_limit'));

		$publish['UserDataPublish'] = $this->get_publish_list('UserDataPublish',$this->user_obj->id,0,config('etc.user_center.publish.render_limit'));

		echo json_encode($publish);

	}

	public function get_more(Request $request){

		$model = $request->input('model');

		$page = $request->input('page');

		$page_info = page_helper($page,config('etc.user_center.publish.render_limit'),config('etc.user_center.publish.limit'));

		$publish = $this->get_publish_list($model,$this->user_obj->id,$page_info['skip'],$page_info['limit']);

		return $publish;
	}

	public function get_publish_list($model,$uid,$skip,$limit){

		$model_obj = get_model_obj($model);

		$publish = $model_obj->user_publish($uid,$skip,$limit);

		return $publish;
	}

	public function delete(Request $request){

		$model = $request->input('model');

		$id = $request->input('id');

		$model_obj = get_model_obj($model);
		
		$obj = $model_obj->find($id);

		if (!$obj) {

			echo json_encode(['code'=>0,'msg'=>'相关模型ID已不存在']);

			die;
		}

		$obj->status = -1;

		$obj->save();		

		echo json_encode(['code'=>1,'msg'=>'删除成功']);
	}
}