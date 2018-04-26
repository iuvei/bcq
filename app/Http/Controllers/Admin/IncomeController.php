<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Income;
use App\Models\AdminModels\Message;

class IncomeController extends Controller
{
    protected $passField = [
        'uid','price','phone','city','payment','accountnumber','accountname','banknumber','bankname','ip','status'
    ];

    public function income_list(Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
                $orOpt['describe'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Income::getIncome(0,10,true,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.income.income-list',compact('object'));
    }

    public function income_ajax_list(Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['describe'] = array('like','%'.$sSearch.'%');
        }

        $object = Income::getIncome($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt);
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Income::getIncomeCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function income_edit(Income $obj){
        $oldStatus = $obj->status;
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'status' => 'required|integer',
            ]);
            //数据库操作
            $obj->status = request()->get('status');

            if($obj->save()){
                if (intval($obj->status) == 1 && intval($oldStatus) == 0){
                    Message::create(
                        ['from' => 1,'to' => $obj->uid,'status' => 1,'content' => "你于 $obj->created_at 申请提成的要求，已通过确认阶段，请依然确保联络方式通畅，作业过程中，如有问题，我们会有专人与您联络。"]

                    );
                }elseif(intval($obj->status) == 2 && intval($oldStatus) != 2){
                    Message::create(
                        ['from' => 1,'to' => $obj->uid,'status' => 1,'content' => "你于 $obj->created_at 申请提成的要求，已成功支付。"]
                    );
                }
            }
            //返回结果
        }
        $table = $obj->getTable();
        return view('Admin.income.income-edit',compact('obj','table'));
    }

}
