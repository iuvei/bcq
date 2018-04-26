<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use FileSystem;
use DisplaySystem;
use App\Models\Slide;
use App\Http\Controllers\CommonController as Common;
use Closure;
class HomePageController extends Controller
{
    protected $newsOpt = [];

    protected $uid; 

    public function __construct(Request $request)
    {
        $this->newsOpt = ['order_by_update'=>1,'top'=>1,'field'=>['View','Comment']];

        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;
            }
            return $next($request);

        });
    }

    public function render(){

        $adsList = AdvertisingSystem::getAds(config('etc.homepage.page_id'));//获取首页所有广告位广告信息

        $render = [
            'adList'=>$adsList
        ];

        echo json_encode($render);
    }

    public function left_render(){

        $leftList = $this->HomePageLeftList();//首页左侧列表

        $render = [
            'leftList'=>$leftList
        ];

        echo json_encode($render);
    }

    public function falls_render(Request $request){

        $page = $request->input('page');

        $model = $request->input('type');

        $cid = $request->input('cid');

        $uid = empty($request->input('uid'))?'':$request->input('uid');

        $auid = $this->uid;

        $falls_obj = get_model_obj('Falls');

        $page_info = page_helper($page,config('etc.homepage.falls.render_limit'),config('etc.homepage.falls.limit'));

        $falls = $falls_obj->GetFallsList($page_info['skip'],$page_info['limit'],$model,$cid,$uid,$this->uid);

        echo json_encode($falls);

        die;
    }

    public function falls_test(){
        
        $falls_obj = get_model_obj('Falls');

        $falls = $falls_obj->InsetToFalls('Platform',691);

        dd($falls);        
    }

    public function HomePageLeftList(){

        //获取最新咨询，最新资讯就是推荐咨询

        //$newsList = $this->getList('News',0,config('etc.homepage.news.render_limit'),$this->newsOpt);

        $slide = Slide::getSlide(config('etc.homepage.slide.slide_limit'));

        //$secondary = Slide::getSecondary(config('etc.homepage.slide.secondary_limit'));

        //$leftList['newsList'] = $newsList;

        $leftList['slide'] = $slide;

        //$leftList['secondary'] = $secondary;

        $leftList['slide_type'] = config('base.slide_type');

        return $leftList;
    }

    //获取news分页信息
    public function getNewsList(Request $request){

        if ($request->input('cid')) {
            $this->newsOpt['cid'] = $request->input('cid');
        }
        
        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.homepage.news.render_limit'),config('etc.homepage.news.limit'));

        $list = $this->getList('News',$page_info['skip'],$page_info['limit'],$this->newsOpt);

        echo json_encode($list);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

    public function UploadImage(Request $request){

        $image = $request->input('image');

        if (empty($this->uid)) {
            
            echo json_encode(['code'=>0,'msg'=>'用户参数错误']);

            die;
                        
        }

        if (empty($image)){

            echo json_encode(['code'=>0,'msg'=>'图片不得为空']);

            die;
        }

        $dir = 'micro/'.$this->uid;

        $path_ret = FileSystem::uploadPublicFileBase64($image,$dir);

        if (!$path_ret['code']) {
            echo json_encode(['code'=>0,'msg'=>'上传图片失败']);
            die;
        }

        echo json_encode(['code'=>1,'path'=>$path_ret['path']]);

     }
}