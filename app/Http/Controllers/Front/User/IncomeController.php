<?php

namespace App\Http\Controllers\Front\User;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Income;
use Authentication;
class IncomeController extends UserCenterController //用户收益
{

	public function getReportBar(){

		$data['view_total'] = get_model_obj('News')->getUsreView($this->user_obj->id,'','');//总点击量

		$start = date('Y-m-1');

		$end = date('Y-m-d H:i:s');

		$data['income_total'] = $this->common_obj->IncomeComputer($data['view_total']);//总收益

		$data['income_total'] = intval($data['income_total']);
		
		$data['income_pick'] = Income::Takeout($this->user_obj->id);//已提取的收益

		$data['income_last'] = $data['income_total']-$data['income_pick'];//剩余的收益

		$trend = get_model_obj('ViewRecord')->GetViewTrend($this->user_obj->id);

		if ($trend['last_month_view']<$trend['this_month_view']) {

			$data['view_trend'] = 1;

		}else{

			$data['view_trend'] = 0;

		}

		$data['view_month'] = $trend['this_month_view'];//当月点击量

		echo json_encode($data);

	}

	public function getRecordList(Request $request){

		$page = $request->input('page');

		$start = $request->input('start');

		$end = $request->input('end');

		if ($page) {
			
			$limit = 20;
			
			$skip = $limit*($page-1);
		
		}else{
			
			$limit = 10;
			
			$skip = 0;
		}

		$data = News::getIncomeList($this->user_obj->id,$start,$end,$limit,$skip);				

		
		foreach ($data['lists'] as $key => $value) {
			$data['lists'][$key]->income = $this->common_obj->IncomeComputer($value->f_view);
		}

		echo json_encode($data);

	}


	public function takeoutRequest(Request $request){//处理用户提取请求

		$authcode = $request->input('authcode');

        $data['phone'] = $request->input('zonecode').$request->input('phone');

        $data['ip'] = $request->getClientIp();   

        $data['price'] = $request->input('takeout');   

        $data['city'] = $request->input('city');   

		$data['payment'] = $request->input('payment');   

		$data['banknumber'] = $request->input('banknumber');   

		$data['accountnumber'] = $request->input('accountnumber');   

		$data['banknumber'] = $request->input('banknumber');   

		$data['accountname'] = $request->input('accountname');   

        $verify = Authentication::verifyCode($data['phone'],$authcode);

        if (!$verify['code']){

            echo json_encode(['code'=>0,'msg'=>$verify['msg']]);

            die();
        }

        $income_last = $this->incomeLast();

        if ($data['price']>$income_last||$data['price']<15) {
            
            echo json_encode(['code'=>0,'msg'=>'输入提取金额有误']);

            die();        	
        
        }

        if (!$data['city']||!$data['payment']) {
            
            echo json_encode(['code'=>0,'msg'=>'地区或支付方式信息有误']);

            die();  
        }

        if ($data['payment']=='银行卡') {
        	
        	if (!$data['banknumber']||!$data['bankname']) {
        		
        		echo json_encode(['code'=>0,'msg'=>'请完善银行卡信息']);

            	die(); 
        	}

        }else{

        	if (!$data['accountnumber']||!$data['accountname']) {
        		
        		echo json_encode(['code'=>0,'msg'=>'请完善账户信息']);

            	die(); 
        	}
        }

        $income_obj = new Income;

        $income_obj->uid = $this->user_obj->id;

        foreach ($data as $key => $value) {
        	if ($value) {
        		$income_obj->$key = $value;
        	}
        }

        $income_obj->save();

        $message = '你于 '.date('Y-m-d H:i:s').' 申请提成的要求，已进入审核阶段，请确保联络方式通畅，作业过程中，如有问题，我们会有专人与您联络。';

        get_model_obj('Message')->sendMessage(1,$this->user_obj->id,$message);
		
		echo json_encode(['code'=>1,'msg'=>'已成功提交申请,审核通过会将钱打入您的账户']);

	}


	public function incomeLast(){

		$view_total = get_model_obj('News')->getUsreView($this->user_obj->id,'','');//总点击量

		$income_total = $this->common_obj->IncomeComputer($view_total);//总收益
		
		$income_pick = Income::Takeout($this->user_obj->id);//已提取的收益

		$income_last = $income_total-$income_pick;//剩余的收益	

		return $income_last;

	}	


	public function getIncomeList(Request $request){

		$page = $request->input('page');

		$limit = 20;

		$skip = $limit*($page-1);

		$data = Income::getIncomeList($this->user_obj->id,$limit,$skip);

		$count = Income::getIncomeCount($this->user_obj->id);

		echo json_encode(['list'=>$data,'count'=>$count]);

	}

	public function takeoutCancel(Request $request){

		$id = $request->input('id');
		
		$obj = Income::where('id',$id)->where('uid',$this->user_obj->id)->first();

		if (!$obj) {
			echo json_encode(['code'=>0,'msg'=>'用户id有误']);
			die;
		}

		$obj->status = -2;

		$obj->save();

		echo json_encode(['code'=>1,'msg'=>'取消提取']);

	}

}
