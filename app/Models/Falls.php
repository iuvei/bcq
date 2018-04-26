<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Falls extends Model
{
	protected $table = 'falls';

	protected $fillable = ['cid','model','status','title','uid'];
    //首页信息流
	public function GetFallsList($skip,$limit,$model,$cid,$uid,$auid){//获取首页信息流

		$datas = Falls::where('falls.status',1);

		if ($model) {

			$datas = $datas->where('falls.model',$model);

			if (($model == 'News')&&$cid) {

				$datas = $datas->join('news','falls.cid','=','news.id')

				->where('news.status',1)

				->where('news.cid',$cid);
			}
		}

		if (!empty($uid)) {
			$datas = $datas->where('uid',$uid);
		}

		$datas = $datas->select('falls.cid','falls.model')

				->skip($skip)

				->limit($limit)

				->orderBy('falls.updated_at','desc')

				->get();

		$falls = [];

		foreach($datas as $key=>$data){

			$ret = $this->AssembleData($data->model,$data->cid,$auid); 

			if(!$ret){
			
				continue;
			}

			$falls[] = $ret;
		}

		return $falls;
	}

	public function AssembleData($model,$id,$auid){

		$model_obj = get_model_obj($model);

		if (empty($model)||empty($id)) {
			return false;
		}

		$data = $model_obj->AssembleData($id,$auid);

		if (empty($data)) {
			return false;
		}

		$data->model = $model;

		return $data;
		
	}

	public function InsetToFalls($model,$id,$uid,$title='未命名'){

		$falls = Falls::updateOrCreate(
		    ['model'=>$model,'cid'=>$id],['status'=>1,'uid'=>$uid,'title'=>$title]
		);

		return $falls;
	}

	public function DropFallsById($id){

		$falls = Falls::find($id);

		$falls->status = 0;

		$falls->save();

		return $falls->id;
		
	}

	public function InTheFalls($model,$id){

		$falls = Falls::where('model',$model)->where('cid',$id)->where('status',1)->first();

		if (!$falls) {
			return false;
		}

		return $falls->id;
	}


	public function FallsCount($uid){
		
		$count = Falls::where('uid',$uid)->where('status',1)->count();

		if (empty($count)) {
			$count = 0;
		}

		return $count;
	}
}
