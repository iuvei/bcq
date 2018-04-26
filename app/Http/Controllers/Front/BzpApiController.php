<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BzpApiController extends Controller
{
    //伯招聘接口
	public function AddCompanyInfo(Request $request){

		$data = $request->input();

		$tocken = $data['bzp_tocken'];

		if ($tocken!==config('base.bzp_tocken')) {

			return ['code'=>0,'msg'=>'tocken dismatch'];

		}

		unset($data['bzp_tocken']);

		$company_obj = get_model_obj('Company');

		if (empty($data['username'])) {

			return ['code'=>0,'msg'=>'username empty'];

		}elseif(empty($data['image'])){

			return ['code'=>0,'msg'=>'image empty'];

		}elseif(empty($data['company'])){

			return ['code'=>0,'msg'=>'componany empty'];

		}

		foreach ($data as $key => $value) {

			if (!empty($value)) {

				$company_obj->$key = $value;

			}
		}

		$company_obj->save();

		return ['code'=>1,'msg'=>'success'];

	}

	public function AddCompanyCommentInfo(Request $request){

		$data = $request->input();

		$tocken = $data['bzp_tocken'];

		if ($tocken!==config('base.bzp_tocken')) {

			return ['code'=>0,'msg'=>'tocken dismatch'];

		}

		unset($data['bzp_tocken']);

		$company_comment_obj = get_model_obj('CompanyComment');


		if (empty($data['username'])) {

			return ['code'=>0,'msg'=>'username empty'];

		}elseif(empty($data['image'])){

			return ['code'=>0,'msg'=>'image empty'];

		}elseif(empty($data['company'])){

			return ['code'=>0,'msg'=>'componany empty'];

		}elseif (empty($data['type'])) {
			return ['code'=>0,'msg'=>'type empty'];
		}		

		foreach ($data as $key => $value) {

			if (!empty($value)) {

				$company_comment_obj->$key = $value;
			}
		}

		$company_comment_obj->save();

		return ['code'=>1,'msg'=>'success'];
	
	}

	public function test(Request $request){

		$msg = $request->input('msg');

    	$url = 'http://127.0.0.1:3000/test';

    	$data = json_encode(['code'=>1,'msg'=>$msg]);

        $headers[] = 'Content-Type: application/json; charset=utf-8';         

    	$ret = curl_post($url,$data,$headers);

    	dd($ret);
	}
}
