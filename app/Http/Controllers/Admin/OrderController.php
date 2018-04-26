<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\Order;

class OrderController extends Controller
{
    protected $passField = [
        'hot','sort','title','image','content','status'
    ];

    public function order_list(Request $request){
        if($request->isMethod('post')){
            $opt = array();
            if ($request->post('pay_type')){
                $opt['pay_type'] = $request->post('pay_type');
            }
            if ($request->post('type')){
                $opt['type'] = $request->post('type');
            }

            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $suname = $request->post('suname')?$request->post('suname'):'';
            $payOpt = array();
            $userOpt = array();
            if ($sSearch){
                $payOpt['title'] = array('like','%'.$sSearch.'%');
            }
            if ($suname){
                $userOpt['username'] = array('like','%'.$suname.'%');
                $userOpt['phone'] = array('like','%'.$suname.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Order::getOrder(0,10,true,$opt,$payOpt,$userOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.order.order-list',compact('object'));
    }

    public function order_ajax_list(Request $request){
        $payOpt = array();
        $userOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $payOpt['title'] = array('like','%'.$sSearch.'%');
        }

        $object = Order::getOrder($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,array(),$payOpt,array(),array());
        $Order = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Order['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Order::getOrderCount();
            $Order['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Order);

        //dd($object['order']);
        //return view('Admin.user.user-list', compact('user'));
    }



}
