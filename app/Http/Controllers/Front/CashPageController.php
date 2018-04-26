<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cash;
use DisplaySystem;
class CashPageController extends Controller
{
    protected $cashOpt;

    protected $orderBy = [['name'=>'按热度排序','val'=>'view'],['name'=>'按时间排序','val'=>'created_at'],['name'=>'按评分排序','val'=>'mark']];

    protected $passField = [
        'title','sort','access','games','region','addip','url1','url2','url3','url4','content','logo'
    ];

    public function __construct(Request $request)
    {
        $cashOpt = ['field'=>[],'orderBy'=>'view'];

        $this->cashOpt = $cashOpt;
    }

    public function render(Request $request){
        $cashList = $this->getList('Cash',0,config('etc.cash.limit.cash'),$this->cashOpt);
        $cashCount = Cash::getCount($this->cashOpt);
        echo json_encode([
            'cashList'=>$cashList,
            'cashCount'=>$cashCount,
            'limit'=>config('etc.cash.limit.cash'),
            'orderBy'=>$this->orderBy,
            'access'=>config('etc.access'),
            'region'=>config('etc.region'),
            'gameList'=>config('etc.games')
        ]);
    }

    public function filter(Request $request){
        if ($request->input('title')){
            $this->cashOpt['title'] = $request->input('title');
        }
        if ($request->input('access')){
            $this->cashOpt['access'] = intval($request->input('access'));
        }
        if ($request->input('games')){
            $this->cashOpt['games'] = intval($request->input('games'));
        }
        if ($request->input('region')){
            $this->cashOpt['region'] = intval($request->input('region'));
        }
        if ($request->input('orderBy')){
            $this->cashOpt['orderBy'] = $request->input('orderBy');
        }
        $limit = config('etc.cash.limit.cash');

        $page = intval($request->input('page'))-1;

        $cashList = $this->getList('Cash',$page,$limit,$this->cashOpt);

        $cashCount = Cash::getCount($this->cashOpt);

        echo json_encode(['cashList'=>$cashList,'cashCount'=>$cashCount]);
    }

    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

    public function addCash(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required',
                'access' => 'required',
                'games' => 'required',
                'region' => 'required|integer',
                'url1' => 'required|nullable|url',
                'url2' => 'nullable|url',
                'url3' => 'nullable|url',
                'url4' => 'nullable|url',
                'content' => 'required|max:21845',
            ]);
            //数据库操作
            foreach ($request->all() as $key => $val){
                if(in_array($key,$this->passField)){
                    if($key == 'access' || $key == 'games'){
                        $data[$key] = array_sum($val);
                    }else{
                        if (!is_numeric($val)){	$val = clean($val);}
                        $data[$key] = $val;
                    }
                }
            }
            $data['addip'] = $request->getClientIp();
            $data['sort'] = 0;
            $data['view'] = 0;
            $data['status'] = 0;
            $res = Cash::create($data);
            if ($res){
                $return['code'] = 200;
                $return['msg'] = '提交成功！';
            }else{
                $return['code'] = 0;
                $return['msg'] = '提交失败,请刷新页面后重试！';
            }
            echo json_encode($return);exit();
            //返回结果
        }
        echo json_encode([
            'accessList'=>config('etc.access'),
            'regionList'=>config('etc.region'),
            'gameList'=>config('etc.games')
        ]);
    }
}
