<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class componentsConfig extends Model
{
    //获取页面右侧组件
    protected $table = 'components_config';

    static function rightList($pid){//$pid 页面ID
    	$right_list = componentsConfig::where('status',1)
    	->where('pid',$pid)
    	->select('id','cid','title')
    	->orderBy('sort','desc')
    	->get();
    	return $right_list;
    }

}
