<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DisplaySystem;
use AdvertisingSystem;
use Closure;
class ReportPageController extends Controller
{

    protected $reportOpt;

    protected $uid;

    public function __construct(Request $request){

        $this->reportOpt = ['field'=>['View','Comment','Collection']];

            $this->middleware(function ($request,Closure $next){

            $user_info = get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;
                //登陆后才显示关注状态
                $this->reportOpt = ['field'=>['View','Comment','Collection'],'is_collected'=>$this->uid];

            }
            return $next($request);
        });        
    }

    public function render(){

        $adsList = AdvertisingSystem::getAds(config('etc.report.page_id'));//获取该页所有广告位广告信息

        $reportList = $this->getList('Report',0,config('etc.report.report.render_limit'),$this->reportOpt);

        $report_obj = get_model_obj('Report');

        $report_more = $report_obj->getMoreReport();

        $render = [
            'adList'=>$adsList,
            'reportList'=>$reportList,
            'report_more'=>$report_more
        ];

        echo json_encode($render);
    }

    public function getReportList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.report.report.render_limit'),config('etc.report.report.limit'));

        $reportList = $this->getList('Report',$page_info['skip'],$page_info['limit'],$this->reportOpt);

        echo json_encode($reportList);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}
