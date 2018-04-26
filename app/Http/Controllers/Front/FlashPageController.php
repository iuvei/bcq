<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DisplaySystem;
use App\Models\Flash;
use App\Http\Controllers\CommonController as Common;
class FlashPageController extends Controller
{
    public function render(Request $request){

        $top_id = $request->input('id');

        $top_flush = '';

        if ($top_id) {
            
            $obj = new Flash;       

            $top_flush = $obj->get_top($top_id);
        }

        $page = $request->get('page')?$request->get('page'):0;

        $flashList = $this->getList('Flash',$page,config('etc.real_time_news.limit.flash'));

        $render = [
            'flashList'=>$flashList,
            'top'=>$top_flush
        ];
        echo json_encode($render);
    }

    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}
