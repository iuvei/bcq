<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DisplaySystem;
use Closure;
use App\Models\Message;
use App\Models\Bcategory;
use App\Http\Controllers\CommonController as Common;
use App\Models\componentsConfig;
use Cache;
class ComponentsController extends Controller
{
    private $uid;

    //此控制器获取页面组件的数据
    public function __construct()
    {
        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;

            }
            return $next($request);
        });
    }

    public function flush_cache(){

        Cache::flush();    

    }

    public function get_right_list(Request $request){

        $page_id = $request->input('page_id');

        $cache_key = 'right_list_page_'.$page_id;

        $right_list = Cache::get($cache_key, function() use ($page_id,$cache_key){

            $list = componentsConfig::rightList($page_id); 

            Cache::put($cache_key,$list,10);

            return $list;

        });

        echo json_encode(['right_list'=>$right_list]);

    }

    public function get_mail_count(){//获取用户的未读站内信数量

        if (!$this->uid) {
            
            echo json_encode(['mail_count'=>0]);

            die;

        }

        $mail_count = Message::messageCount($this->uid,1);

        echo json_encode(['mail_count'=>$mail_count]);
    }

    public function get_cat_list(){

        $cache_key = 'nav_bcategory';

        $catList = Cache::get($cache_key, function() use ($cache_key){

            $category_obj = new Bcategory();
            
            $list = $category_obj->getRecommendList();

            Cache::put($cache_key,$list,30);

            return $list;

        });

        echo json_encode(['catList'=>$catList]);
    }

    //获取专题数据
    public function get_special(Request $request){

        $specialOpt  = ['hot'=>1];

        $page = $request->input('page');

        $render_limit = config('etc.components.special.render_limit');

        $page_limit = config('etc.components.special.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);//表示 limit 和 skip 是多少

        $specialList = $this->getList('Special',$page_info['skip'],$page_info['limit'],$specialOpt);

        echo json_encode(['specialList'=>$specialList]);
    }

    public function get_news(Request $request){

        $newsOpt = ['order_by_update'=>1,'field'=>['View','Comment','Collection']];

        if ($this->uid){
            $newsOpt = ['order_by_update'=>1,'field'=>['View','Comment','Collection'],'is_collected'=>$this->uid];
        }

        $page = $request->input('page');

        $render_limit = config('etc.components.news.render_limit');

        $page_limit = config('etc.components.news.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);//表示要 limit 和 skip 多少

        $newsList = $this->getList('News',$page_info['skip'],$page_info['limit'],$newsOpt);

        echo json_encode(['newsList'=>$newsList]);
    }

    public function get_user_data(Request $request){

        $userDataOpt = [];

        if ($this->uid){
            $userDataOpt = ['is_collected'=>$this->uid];
        }

        $page = $request->input('page');

        $render_limit = config('etc.components.user_data.render_limit');

        $page_limit = config('etc.components.user_data.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);//表示要 limit 和 skip 多少

        $UserData = $this->getList('UserData',$page_info['skip'],$page_info['limit'],$userDataOpt);

        echo json_encode(['UserData'=>$UserData]);
    }

    public function get_report(Request $request){

        $reportOpt = [];

        $page = $request->input('page');

        $render_limit = config('etc.components.report.render_limit');

        $page_limit = config('etc.components.report.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);//表示要 limit 和 skip 多少

        $reportList = $this->getList('Report',$page_info['skip'],$page_info['limit'],$reportOpt);

        echo json_encode(['reportList'=>$reportList]);

    }

    public function get_business(Request $request){

        $businessOpt1 = ['hot'=>1,'type'=>1];

        $businessOpt2 = ['hot'=>1,'type'=>2];

        $page = $request->input('page');

        $render_limit = config('etc.components.business.render_limit');

        $page_limit = config('etc.components.business.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);//表示要 limit 和 skip 多少

        $businessList1 = $this->getList('Business',$page_info['skip'],$page_info['limit'],$businessOpt1);

        $businessList2 = $this->getList('Business',$page_info['skip'],$page_info['limit'],$businessOpt2);

        $businessList1 = $businessList1?$businessList1->sortByDesc('confirm'):[];

        $businessList2 = $businessList2?$businessList2->sortByDesc('confirm'):[];

        $data['sale'] = isset($businessList1)?$businessList1:[];

        $data['purchase'] = isset($businessList2)?$businessList2:[]; 

        echo json_encode($data);
    }

    public function get_platform(Request $request){

        $platformOpt = ['hot'=>1];

        $page = $request->input('page');

        $render_limit = config('etc.components.platform.render_limit');

        $page_limit = config('etc.components.platform.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);//表示要 limit 和 skip 多少

        $platformList = $this->getList('Platform',$page_info['skip'],$page_info['limit'],$platformOpt);

        echo json_encode(['platformList'=>$platformList]);

    }

    public function get_author(){//获取推荐作者列表
        
        $model_obj = get_model_obj('Author');

        $author_list = $model_obj->get_components();

        echo json_encode($author_list);

    }

    public function get_hot_news(){//获取热点新闻
        
        $model_obj = get_model_obj('News');

        $hot_news_list = $model_obj->get_hot_news();

        echo json_encode($hot_news_list);
        
    }

    public function get_hot_special(){//获取热点专题
        
        $model_obj = get_model_obj('Special');

        $hot_special_list = $model_obj->get_hot_special();

        echo json_encode($hot_special_list);
        
    }    

    public function get_hot_question(){

        $model_obj = get_model_obj('Question');

        $hot_question_list = $model_obj->get_hot_question();

        echo json_encode($hot_question_list);

    }

    public function get_new_exhibition(){

        $model_obj = get_model_obj('Exhibition');

        $exhibition = $model_obj->get_new_exhibition();

        if (!empty($exhibition)) {
            $exhibition->startdate = date('Y/m/d',$exhibition->starttime);
            $exhibition->enddate = date('Y/m/d',$exhibition->endtime);   
            $exhibition->format = $exhibition->starttime;                  
        }

        echo json_encode($exhibition);      

    }

    public function get_exhibition_news(){

        $model_obj = get_model_obj('Exhibition');

        $exhibition = $model_obj->get_exhibition_news();

        echo json_encode($exhibition);      

    }

    public function get_brief_list(){

        $model_obj = get_model_obj('Exhibition');        

        $exhibition = $model_obj->getBriefList();

        echo json_encode($exhibition);
    }

    public function get_flash(){

        $model_obj = get_model_obj('Flash');

        $flash = $model_obj->get_flash();

        echo json_encode($flash);         
    }

    public function get_hot_download(){

        $model_obj = get_model_obj('UserData');

        $download = $model_obj->get_hot_download();

        echo json_encode($download);                
    }

    public function get_week_hot_news(){

        $model_obj = get_model_obj('News');

        $news = $model_obj->get_week_hot_news();

        echo json_encode($news);         

    }

    public function get_notice_list(){

        $model_obj = get_model_obj('Notice');

        $notice = $model_obj->getNoticeList();

        echo json_encode($notice);         

    }

    public function getIncome(){
        
        $common_obj = new Common;

        $view_total = get_model_obj('News')->getUsreView($this->uid,'','');//总点击量

        $income_total = $common_obj->IncomeComputer($view_total);//总收益

        $income_total = intval($income_total);

        echo json_encode($income_total);
    }


    public function getNewsCats(){

        $cats = get_model_obj('NewsCategory')->getCategory('=',1,'sort');//总点击量

        echo json_encode($cats);
    }

    public function GetGameInfo(){
        
        $game_obj = get_model_obj('Micro');//总点击量
       
        $gameinfo = $game_obj->GetNewInfo();

        echo json_encode($gameinfo);

    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }    
}
