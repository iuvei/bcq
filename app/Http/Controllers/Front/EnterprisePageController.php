<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enterprise;
use DisplaySystem;
use Illuminate\Support\Facades\Hash;
class EnterprisePageController extends Controller
{
    //企业库
    protected $enterpriseOpt;

    protected $passField = [
        'scale','region','addip','title','content','logo','url'
    ];
    public function __construct()
    {
        $this->enterpriseOpt = ['field'=>['View']];
    }

    public function render(){

        $enterpriseList = $this->getList('Enterprise',0,config('etc.enterprise.limit.enterprise'),$this->enterpriseOpt);
        $enterpriseCount = Enterprise::getCount();

        echo json_encode([
            'enterpriseList'=>$enterpriseList,
            'scaleList'=>config('etc.scale'),
            'regionList'=>config('etc.region'),
            'limit'=>config('etc.enterprise.limit.enterprise'),
            'enterpriseCount'=>$enterpriseCount,
        ]);

    }

    public function filter(Request $request){

        $limit = config('etc.enterprise.limit.enterprise');

        $page = intval($request->input('page'))-1;

        $enterpriseList = $this->getList('Enterprise',$page,$limit,$this->enterpriseOpt);

        $enterpriseCount = Enterprise::getCount();

        echo json_encode(['enterpriseList'=>$enterpriseList,'enterpriseCount'=>$enterpriseCount]);
    }

    public function getList($model,$page,$limit,$opt = []){

        $skip = $page * $limit;

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

    public function addEnterprise(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'scale' => 'required|integer',
                'region' => 'required|integer',
                'title' => 'required',
                'content' => 'required|max:21845',
                'url' => 'required|url',
            ]);
            //数据库操作
            foreach ($request->all() as $key => $val){
                if(in_array($key,$this->passField)){
                    if (!is_numeric($val)){	$val = clean($val);}
                    $data[$key] = $val;
                }
            }
            $data['addip'] = $request->getClientIp();
            $data['sort'] = 0;
            $data['famous'] = 0;
            $data['view'] = 0;
            $data['status'] = 0;
            $res = Enterprise::create($data);
            if ($res){
                $return['code'] = 200;
                $return['msg'] = '提交成功！';
            }else{
                $return['code'] = 0;
                $return['msg'] = '提交失败,请刷新页面后重试！';
            }
            echo json_encode($return);exit();
        }
        echo json_encode([
            'scaleList'=>config('etc.scale'),
            'regionList'=>config('etc.region'),
        ]);
    }
}
