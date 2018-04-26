<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use Closure;
class NewsPageController extends Controller
{
    protected $newsOpt = [];

    public function __construct(Request $request)
    {
        $this->newsOpt = ['order_by_update'=>1,'field'=>['View','Comment','Collection']];

        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $uid = $user_info['user']->id;

                $this->newsOpt = ['order_by_update'=>1,'field'=>['View','Comment','Collection']];
            }
            return $next($request);

        });
    }

    //产业资讯
    public function render(){

//当用户登录时会有关注状态，针对某篇文章会有是否收藏等状态

        $newsList = $this->getList('News',0,config('etc.news.news.render_limit'),$this->newsOpt);

        $render = [
            'newsList'=>$newsList
        ];

        echo json_encode($render);
    }

    public function getNewsList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.news.news.render_limit'),config('etc.news.news.limit'));

        $newslist = $this->getList('News',$page_info['skip'],$page_info['limit'],$this->newsOpt);

        echo json_encode($newslist);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}