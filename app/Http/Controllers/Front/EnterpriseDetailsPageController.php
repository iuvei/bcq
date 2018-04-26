<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use Closure;
use App\Http\Controllers\CommonController as Common;
use Illuminate\Support\Facades\Redis;
use App\Models\Enterprise;
class EnterpriseDetailsPageController extends Controller
{
    protected $uid;

    protected $enterprise_obj;

    protected $common_obj;

    public function __construct()
    {
        $this->enterprise_obj = new Enterprise;

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

        $eid = $request->get('eid');

        $ip = $request->getClientIp();;

        $this->common_obj->addView('Enterprise',$eid,$ip);//增加一次浏览量

        $enterprise_details = $this->enterprise_obj->getDetails($eid);

        $render = [
            'enterpriseDetails'=>$enterprise_details,
            'scaleList'=>config('etc.scale'),
            'regionList'=>config('etc.region'),
        ];
        echo json_encode($render);
    }

}