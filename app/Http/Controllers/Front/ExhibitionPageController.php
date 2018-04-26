<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cash;
use DisplaySystem;
class ExhibitionPageController extends Controller
{
    public function render(Request $request){
        $exhibitionList = $this->getList('Exhibition',0,config('etc.exhibition.exhibition.render_limit'),[]);
        echo json_encode([
            'exhibitionList'=>$exhibitionList,
        ]);
    }

    public function getExhibitionList(Request $request){

        $limit = config('etc.exhibition.exhibition.limit');

        $page = intval($request->input('page'));

        $exhibitionList = $this->getList('Exhibition',$page,$limit,[]);

        echo json_encode($exhibitionList);
    }

    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}
