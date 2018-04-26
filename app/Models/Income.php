<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'income';

    static function Takeout($uid){//已提取的收益

 		$price = Income::where('uid',$uid)->whereIn('status',[0,1,2])->sum('price');   	

 		return $price;

    }


    static function getIncomeList($uid,$limit,$skip){

    	$data = Income::where('uid',$uid)

    	->select('id','created_at','price','status')

    	->limit($limit)

    	->skip($skip)

    	->latest()

    	->get();

    	return $data;
    }

    static function getIncomeCount($uid){

    	$count = Income::where('uid',$uid)->count();

    	return $count;
    }

}
