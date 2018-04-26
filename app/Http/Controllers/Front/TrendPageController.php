<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use App\Models\Trend as Trend;
use Closure;
class TrendPageController extends Controller
{

    protected $trendOpt;

    protected $authorOpt;

    protected $user;

    public function __construct(Request $request){

        $this->trendOpt = ['page'=>'trend','field'=>['View','Comment','Collection']];

        $this->authorOpt = ['recommend'=>1];

        //当用户登录时会有关注状态，针对某篇文章会有是否收藏等状态

        $this->middleware(function ($request,Closure $next){

            $user_info = get_user_info();

            if ($user_info['code'] == 1){

                $this->user = $user_info['user'];
                //登陆后才显示关注状态
                $this->authorOpt = ['recommend'=>1,'is_attention'=>$this->user->id];

            }
                return $next($request);
        });
    }

    public function render(Request $request){

        $top_trend = '';
        
        $top_id = $request->input('id');

        if ($top_id) {
            
            $obj = new Trend;       

            $top_trend = $obj->get_top($top_id);
        }

        $trendList = $this->getList('Trend',0,config('etc.trend.trend.render_limit'),$this->trendOpt);

        $trendList = $trendList->groupBy('date')->sortByDesc('date');//按照时间分组

        $count = $this->get_count();

        $render = [
            'trendList'=>$trendList,
            'trend_count'=>$count,
            'top_trend'=>$top_trend
        ];

        echo json_encode($render);
    }

    public function get_count(){

        $trend_obj = new Trend;

        $count_group = $trend_obj->getCount();

        $count['web'] = 0;

        $count['ios'] = 0;

        $count['ard'] = 0;

        foreach ($count_group as $key => $value) {
          
            if(1&$value->type) {
                $count['web']++;
            }
            if(2&$value->type){
                $count['ard']++;
            }
            if(4&$value->type){
                $count['ios']++;
            }
        }

        return $count;
    }

    public function getTrendList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.trend.trend.render_limit'),config('etc.trend.trend.limit'));

        $trendList = $this->getList('Trend',$page_info['skip'],$page_info['limit'],$this->trendOpt);

        $trendList = $trendList->groupBy('date')->sortByDesc('date');//按照时间分组

        echo json_encode($trendList);
    }

    public function addTrend(Request $request){//发布新产品

        if (!$this->user->id){
            echo json_encode(['code'=>0,'msg'=>'请登陆后发布产品']);
            die;
        }

        $trend['title'] = clean($request->input('title'));

        $trend['content'] = clean($request->input('content'));

        $trend['product_url'] = clean($request->input('url'));

        $trend['type'] = array_sum($request->input('type'));

        $trend['uid'] = $this->user->id;

        $T_obj = new Trend();

        $new_trend = $T_obj->addTrend($trend);

/*        if ($new_trend['code']&&$this->user->level_id>2) {

            get_model_obj('Falls')->InsetToFalls('Trend',$new_trend['id'],$trend['title']);
        
        }
*/
        if (!$new_trend['code']){
            echo json_encode($new_trend);
            die;
        }

        $count = $this->get_count();

        $new_trend['count'] = $count;

        echo json_encode($new_trend);
    }

    public function addView(Request $request){

        $id = $request->input('id');

        $ip = $request->getClientIp(); 

        $common_obj = new Common;

        $common_obj->addView('Trend',$id,$ip);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }
}
