<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\DataComment;

class DataCommentController extends Controller
{
    protected $passField = [
        'uid','did','dcid','top','complaint','content','status'
    ];

    public function data_comment_list(Request $request){
        if($request->isMethod('post')){
            $opt = array();

            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['content'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = DataComment::getDataComment(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.data_comment.data_comment-list',compact('object'));
    }

    public function data_comment_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = DataComment::getDataComment($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $DataComment = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $DataComment['iTotalDisplayRecords'] = count($object);
        } else {
            $count = DataComment::getDataCommentCount();
            $DataComment['iTotalDisplayRecords'] = $count;
        }
        return json_encode($DataComment);

        //dd($object['data_comment']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function data_comment_review(Request $request){
        $object = DataComment::where('complaint','<>',0)->get()->load('user','data','comment');
        return view('Admin.data_comment.data_comment-list',compact('object'));
    }

    public function data_comment_edit(DataComment $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'top' => 'integer',
                'complaint' => 'integer',
                'content' => 'max:255',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                }
            }
            $obj->save();
            //返回结果
        }
        $table = $obj->getTable();
        return view('Admin.data_comment.data_comment-edit',compact('obj','table'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new DataComment();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
