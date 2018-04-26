<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Special;
use App\Models\SpecialNews;
use App\Http\Controllers\CommonController as Common;
class SpecialDetailsPageController extends Controller
{

    protected $special_obj;
    protected $special_news_obj;

    public function __construct()
    {
        $this->special_obj = new Special();
        $this->special_news_obj = new SpecialNews();
    }

    public function render(Request $request){

        $sid = $request->input('sid');

        $special = $this->special_obj->getDetails($sid);

        $skip = 0;
        $limit = config('etc.special_details.render_limit.news');
        $special_news = $this->special_news_obj->getSpecialNews($sid,$skip,$limit);

        $render = [
            'special'=>$special,
            'special_news'=>$special_news
        ];
        echo json_encode($render);
    }

    public function getSpecialNews(Request $request){

        $sid = $request->input('sid');

        $page = $request->get('page')?$request->get('page'):1;

        $limit = config('etc.special_details.render_limit.news');

        $skip = ($page-1) * $limit;

        $special_news = $this->special_news_obj->getSpecialNews($sid,$skip,$limit);

        $render = [
            'special_news'=>$special_news
        ];
        echo json_encode($render);
    }
}