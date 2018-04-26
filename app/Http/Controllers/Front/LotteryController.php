<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LotteryController extends Controller
{
    protected $model_path = "App\\Models\\LotteryModels\\";

    public function arrange($data,$lottery){
        foreach ($data as $key => $val){
            unset($data[$key]['created_at'],$data[$key]['updated_at']);

            $data[$key]['open_time'] = date('Y-m-d H:i',$val['open_time']);
            if ($lottery == 'ssq'){
                $ball =  explode('+',$val['code']);
                $data[$key]['red'] = explode(config('lottery.lottery_list.'.$lottery.'.exp'),$ball[0]);
                $data[$key]['blue'] = explode(config('lottery.lottery_list.'.$lottery.'.exp'),$ball[1]);
            }elseif ($lottery == 'lhc'){
                $ball =  explode(config('lottery.lottery_list.'.$lottery.'.exp'),$val['code']);
                $data[$key]['blue'] = [array_pop($ball)];
                $data[$key]['red'] = $ball;
            }else{
                $exp = config('lottery.lottery_list.'.$lottery.'.exp');
                if ($exp == ' ' || $exp == ',' ){
                    $ball =  explode($exp,$val['code']);
                }else{
                    $ball =  str_split($val['code']);
                }
                $data[$key]['red'] = $ball;
            }
        }
        return $data;
    }

    public function render(Request $request){
        $lottery = $request->get('actionType')?strtolower($request->get('actionType')):'cqssc';

        $page = $request->get('page')?intval($request->get('page')):1;

        $model_name = $this->model_path.config('lottery.lottery_list.'.$lottery.'.model');

        $endTime = date('Y-m-d',time());

        $startTime = date('Y-m-d',strtotime('-1 day',strtotime($endTime)));

        $model = new $model_name;

        $lotteryCount = $model->count();

        $issueRes = $model->latest()->first();
        $issue = $issueRes?$issueRes->issue:0;

        $skip = ($page-1)*config('lottery.limit');

        $limit = config('lottery.limit');

        $lotteryList = $model->skip($skip)->limit($limit)->orderBy('open_time','desc')->get()->toArray();
        $lotteryList = $this->arrange($lotteryList,$lottery);
        $render = [
            'lotteryList'=>$lotteryList,
            'endTime'=>$endTime,
            'startTime'=>$startTime,
            'lotteryCount'=>$lotteryCount,
            'limit'=>$limit,
            'issue'=>$issue,
        ];

        echo json_encode($render);
    }

    public function search(Request $request){
        $lottery = $request->get('actionType');
        $startTime = intval(strtotime($request->get('startTime')));
        $endTime = intval(strtotime($request->get('endTime')));
        if ($startTime > $endTime){
            $startTime = intval(strtotime(date('Y-m-d 23:59:59',$startTime)));
        }else{
            $endTime = intval(strtotime(date('Y-m-d 23:59:59',$endTime)));
        }
        $searchIssue = $request->get('searchIssue');

        $model_name = $this->model_path.config('lottery.lottery_list.'.$lottery.'.model');

        $model = new $model_name;


        $searchRes = $model->whereBetween('open_time',[$startTime,$endTime])->where('issue','like','%'.$searchIssue.'%')->latest()->first();
        $lotteryList = [];
        $lotteryId = 0;
        if($searchRes){
            $lotteryId = $searchRes->id;
            $startId = $lotteryId-(config('lottery.searchLimit')/2);
            $endId = $lotteryId+(config('lottery.searchLimit')/2);
            if($startId <= 0){
                $startId = 0;
                $endId = 50;
            }
            $lotteryList = $model->whereBetween('id',[$startId,$endId])->orderBy('open_time','desc')->get()->toArray();
            $lotteryList = $this->arrange($lotteryList,$lottery);
        }
        $render = [
            'lotteryList'=>$lotteryList,
            'lotteryId'=>$lotteryId,
        ];

        echo json_encode($render);
    }





}