<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use Closure;
use App\Http\Controllers\CommonController as Common;
use Illuminate\Support\Facades\Redis;
use App\Models\Cash;
use App\Models\Cashmark;
class CashDetailsPageController extends Controller
{
    protected $uid;

    protected $cash_obj;

    protected $common_obj;

    public function __construct()
    {
        $this->cash_obj = new Cash;

        $this->common_obj = new Common();   

        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){
                $this->uid = $user_info['user']->id;
            }
            return $next($request);
        });
    }

    public function render(Request $request){

        $cid = $request->input('cid');

        $ip = $request->getClientIp();

        $this->common_obj->addView('Cash',$cid,$ip);  

        $cash_details = $this->cash_obj->getDetails($cid);

        $render = [
            'cashDetails'=>$cash_details
        ];
        echo json_encode($render);
    }

    public function addMark(Request $request){
        
        $cid = $request->input('cid');
        
        $render = [
            'code' => 0,
            'msg' => '系统错误!',
        ];
        
        $ip = $request->getClientIp();
        
        if(Redis::exists($cid.'-cashmark-'.$ip)){        
            $render['msg'] = '已经提交过评分,请勿重复提交!';
            echo json_encode($render);
            exit();
        }

        Redis::incr($cid.'-cashmark-'.$ip);
        $endtime = strtotime(date('Y-m-d 23:59:59',time()));//key过期时间为当天凌晨12点
        Redis::expireAt($cid.'-cashmark-'.$ip,$endtime);

        $passField = ['mark1','mark2','mark3','mark4'];
        foreach ($request->all() as $key => $val){
            if(in_array($key,$passField)){
                $data[$key] = $val*20;
            }
        }
        $data['cid'] = $cid;
        $data['addip'] = $ip;
        $res = Cashmark::create($data);
        if ($res){
            $cash = $this->cash_obj->where('id',$cid)->withCount('cashmark')->first()->load('cashmark');
            $mark1Total = intval($cash->mark1);
            $mark2Total = intval($cash->mark2);
            $mark3Total = intval($cash->mark3);
            $mark4Total = intval($cash->mark4);
            $markNum = count($cash->cashmark) + 1;
            foreach ($cash->cashmark as $val){
                $mark1Total += intval($val->mark1);
                $mark2Total += intval($val->mark2);
                $mark3Total += intval($val->mark3);
                $mark4Total += intval($val->mark4);
            }
            $mark1 = round($mark1Total / $markNum,0);
            $mark2 = round($mark2Total / $markNum,0);
            $mark3 = round($mark3Total / $markNum,0);
            $mark4 = round($mark4Total / $markNum,0);
            $mark = round(($mark1 + $mark2 + $mark3 + $mark4) / 4,0);

            $cash->mark1 = $mark1;
            $cash->mark2 = $mark2;
            $cash->mark3 = $mark3;
            $cash->mark4 = $mark4;
            $cash->mark = $mark;
            $cashres = $cash->save();
            if ($cashres){
                $render = [
                    'code' => 200,
                    'msg' => '提交评分成功',
                    'cashDetails'=>$this->cash_obj->process($cash)
                ];
            }
        }

        echo json_encode($render);
    }

}