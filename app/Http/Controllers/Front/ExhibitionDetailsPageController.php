<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use App\Models\Exhibition;
use App\Models\ExhibitionNews;
use App\Http\Controllers\CommonController as Common;
class ExhibitionDetailsPageController extends Controller
{
    protected $exhibition_obj;

    protected $common_obj;

    protected $exhibition_news_obj;

    public function __construct()
    {
        $this->exhibition_obj = new Exhibition();

        $this->common_obj = new Common();

        $this->exhibition_news_obj = new ExhibitionNews();
    }

    public function render(Request $request){

        $eid = $request->input('eid');

        $ip = $request->getClientIp();

        $this->common_obj->addView('Exhibition',$eid,$ip);//增加一次浏览量

        $adsList = AdvertisingSystem::getAds(config('etc.exhibition_details.page_id'));//获取该页所有广告位广告信息

        $exhibition_details = $this->exhibition_obj->getDetails($eid);

        $skip = 0;
        $limit = config('etc.exhibition_details.render_limit.news');
        $exhibition_news = $this->exhibition_news_obj->getExhibitionNews($eid,$skip,$limit);


        $render = [
            'adsList'=>$adsList,
            'exhibitionDetails'=>$exhibition_details,
            'exhibition_news'=>$exhibition_news,

        ];
        echo json_encode($render);
    }

    public function getExhibitionNews(Request $request){

        $eid = $request->get('eid');

        $page = $request->get('page')?$request->get('page'):0;

        $limit = config('etc.exhibition_details.render_limit.news');

        $skip = intval($page) * $limit;

        $exhibition_news = $this->exhibition_news_obj->getExhibitionNews($eid,$skip,$limit);

        $render = [
            'exhibition_news'=>$exhibition_news
        ];
        echo json_encode($render);
    }
}