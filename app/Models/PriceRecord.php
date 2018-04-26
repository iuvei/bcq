<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceRecord extends Model
{

	protected $table = 'price_record';

	protected $hidden = ['updated_at'];

	static function record($uid,$type,$tid,$price=0){//type=1 用户资料 type=2数据报告 type=3互动问答

		$date = date('Y-m-d H:i:s');

		PriceRecord::insert(['uid'=>$uid,'type'=>$type,'tid'=>$tid,'price'=>$price,'created_at'=>$date,'updated_at'=>$date]);
	
	}

	static function user_record($uid,$skip,$limit){

		$record = PriceRecord::where('uid',$uid);

		$count = $record->count();

		$record = $record

				->skip($skip)

				->limit($limit)

				->get();

		return ['count'=>$count,'record'=>$record];

	}

}