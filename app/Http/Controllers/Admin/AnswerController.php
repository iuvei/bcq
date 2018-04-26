<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Question;
use App\Models\AdminModels\Answer;
use App\Models\AdminModels\User;

class AnswerController extends Controller
{
    protected $passField = [
        'qid','uid','content','sort','status'
    ];
    protected $author;

    public function __construct()
    {
        $this->author = User::getUserAuthor();
    }

    public function answer_list($qid){
        $opt = array('qid'=>$qid);
        $object = Answer::getAnswer($opt)->load('question','user');
        return view('Admin.answer.answer-list',compact('object','qid'));
    }


    public function answer_all_list(Request $request){
        if($request->isMethod('post')){
            $opt = array(
                'status' => array('!=',-1)
            );
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['content'] = '%'.$sSearch.'%';
            }
            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = Answer::getAllAnswer(0,10,true,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.answer.answer-all-list',compact('object'));
    }

    public function answer_ajax_all_list(Request $request){
        $orOpt = array();
        $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
        if ($sSearch){
            $orOpt['content'] = '%'.$sSearch.'%';
        }
        $object = Answer::getAllAnswer($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt,array());
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );
        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Answer::getAllAnswerCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }



    public function answer_add(Question $obj){
        if(request()->isMethod('post')){
            //验证
            $this->validate(request(), [
                'uid' => 'required',
                'content' => 'required|max:21845',
                'sort' => 'integer',
                'status' => 'required',
            ]);

            //数据库操作
            $data = [];
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $data[$key] = $val;
                }
            }

            //返回结果
            $obj->answer()->create($data);
        }
        $author = $this->author;
        return view('Admin.answer.answer-add',compact('author','obj'));
    }

    public function answer_edit(Answer $obj){
        if(request()->isMethod('post')){
            //验证
            $this->validate(request(), [
                'content' => 'required|max:21845',
                'sort' => 'integer',
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
        return view('Admin.answer.answer-edit',compact('obj'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Answer();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
