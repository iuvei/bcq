<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PusherController extends Controller
{
    public function test(){

    	$url = 'http://127.0.0.1:3000/test';

    	$data = json_encode(['code'=>1,'msg'=>'test']);

        $headers[] = 'Content-Type: application/json; charset=utf-8';         

    	$ret = curl_post($url,$data,$headers);

    	echo json_encode($ret);

    }
}