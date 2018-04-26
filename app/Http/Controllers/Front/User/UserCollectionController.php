<?php

namespace App\Http\Controllers\Front\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsCollection;
use App\Models\QuestionCollection;
use App\Models\ReportCollection;
use App\Models\PbCollection;
class UserCollectionController extends UserCenterController
{

	public function render(){

		$collection['NewsCollection'] = $this->get_collection_list('NewsCollection',$this->user_obj->id,0,config('etc.user_center.collection.render_limit'));

		$collection['QuestionCollection'] = $this->get_collection_list('QuestionCollection',$this->user_obj->id,0,config('etc.user_center.collection.render_limit'));

		$collection['ReportCollection'] = $this->get_collection_list('ReportCollection',$this->user_obj->id,0,config('etc.user_center.collection.render_limit'));

		$collection['PbCollection'] = $this->get_collection_list('PbCollection',$this->user_obj->id,0,config('etc.user_center.collection.render_limit'));	

		echo json_encode($collection);

	}

	public function get_more(Request $request){

		$model = $request->input('model');

		$page = $request->input('page');

		$page_info = page_helper($page,config('etc.user_center.collection.render_limit'),config('etc.user_center.collection.limit'));

		$collection = $this->get_collection_list($model,$this->user_obj->id,$page_info['skip'],$page_info['limit']);

		return $collection;
	}

	public function get_collection_list($model,$uid,$skip,$limit){

		$model_obj = get_model_obj($model);

		$collection = $model_obj->user_collection($uid,$skip,$limit);

		return $collection;
	}

}