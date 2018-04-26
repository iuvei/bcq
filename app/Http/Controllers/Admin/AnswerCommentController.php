<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ToolsController;
use App\Models\AdminModels\AnswerComment;

class AnswerCommentController extends Controller
{
    protected $passField = [
        'uid','rid','top','complaint','content','status'
    ];

    public function answer_comment_list(Request $request){
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
            $object = AnswerComment::getAnswerComment(0,10,true,$opt,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.answer_comment.answer_comment-list',compact('object'));
    }

    public function answer_comment_ajax_list(Request $request){
        $opt = array();
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = AnswerComment::getAnswerComment($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$opt,$orOpt,$betweenOpt=array());
        $AnswerComment = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $AnswerComment['iTotalDisplayRecords'] = count($object);
        } else {
            $count = AnswerComment::getAnswerCommentCount();
            $AnswerComment['iTotalDisplayRecords'] = $count;
        }
        return json_encode($AnswerComment);

        //dd($object['answer_comment']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function answer_comment_review(Request $request){
        $object = AnswerComment::where('complaint','<>',0)->get()->load('user','answer.question');
        return view('Admin.answer_comment.answer_comment-list',compact('object'));
    }

    public function answer_comment_edit(AnswerComment $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'complaint' => 'integer',
                'content' => 'required|max:255',
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
        return view('Admin.answer_comment.answer_comment-edit',compact('obj','table'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new AnswerComment();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
