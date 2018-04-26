<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bcategory extends Model
{
    //
    protected $table = 'bcategory';

    public function getBcategoryList($skip=0,$limit=1000,$opt=[]){

    	$categoryList = Bcategory::where('status',1)->select('id','fid','cname')->orderBy('sort','desc')->get();

    	return $categoryList;
    }
    public function getRecommendList(){

    	$categoryList = Bcategory::where('status',1)->where('recommend',1)->select('id','fid','cname')->orderBy('sort','desc')->get();

    	return $categoryList;
    }
}