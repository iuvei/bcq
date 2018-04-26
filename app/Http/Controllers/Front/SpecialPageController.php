<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use DisplaySystem;

class SpecialPageController extends Controller
{
    protected $specialOpt = [];

    public function __construct(Request $request)
    {
        $this->specialOpt = ['order_by' => 'sort'];

    }
    //产业资讯
    public function render(){

//当用户登录时会有关注状态，针对某篇文章会有是否收藏等状态

        $specialList = $this->getList('Special',0,config('etc.special.special.render_limit'),$this->specialOpt);

        $render = [
            'specialList'=>$specialList
        ];

        echo json_encode($render);
    }

    public function getSpecialList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.special.special.render_limit'),config('etc.special.special.limit'));

        $speciallist = $this->getList('Special',$page_info['skip'],$page_info['limit'],$this->specialOpt);

        echo json_encode($speciallist);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}