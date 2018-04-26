<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Question;
use App\Models\AdminModels\User;
use App\Models\AdminModels\Fall;
use App\Models\AdminModels\Message;

class QuestionController extends Controller
{
    protected $passField = [
        'uid','rid','title','describe','price','sort','status'
    ];
    protected $author;

    public function __construct()
    {
        $this->author = User::getUserAuthor();
    }

    public function question_list(Request $request){
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
            $object = Question::getQuestion(0,10,true,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        return view('Admin.question.question-list',compact('object'));
    }

    public function question_ajax_list(Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['describe'] = array('like','%'.$sSearch.'%');
        }

        $object = Question::getQuestion($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt);
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = Question::getQuestionCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function question_review(Request $request){
        $object = Question::where('status',0)->get();
        return view('Admin.question.question-list',compact('object'));
    }

    public function question_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'uid' => 'required|integer',
                'title' => 'required|max:40',
                'describe' => 'required|max:200',
                'price' => 'integer',
                'sort' => 'integer',
                'status' => 'required|integer',
            ]);

            //数据库操作
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'describe'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $data[$key] = $val;
                }
            }
            Question::create($data);
            //返回结果
        }
        $author = $this->author;
        return view('Admin.question.question-add',compact('author'));
    }

    public function question_edit(Question $obj){
        $oldStatus = $obj->status;
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'required|max:40',
                'describe' => 'required|max:200',
                'price' => 'integer',
                'sort' => 'integer',
                'status' => 'required|integer',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'describe'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                }
            }
            if($obj->save()){
                if (intval($obj->status) == 1 && intval($oldStatus) == 0){
                    Fall::updateOrCreate(
                        ['title' => $obj->title,'uid' => $obj->uid,'cid' => $obj->id, 'model' => 'Question','status' => 1],
                        ['updated_at' => date('Y-m-d H:i:s')]
                    );
                    Message::create(
                        ['from' => 1,'to' => $obj->uid,'status' => 1,'content' => "你于问答 $obj->created_at 发布的内容，已在".date('Y-m-d H:i:s')." 审核通过，期待你发布更多的产业相关动态。"]
                    );
                }elseif (intval($obj->status) != 1){
                    Fall::where(['cid' => $obj->id])
                        ->where(['model' => 'Question'])
                        ->update(
                        ['status' => 0]
                    );
                }
            }
            //返回结果
        }
        $table = $obj->getTable();
        return view('Admin.question.question-edit',compact('obj','table'));
    }

    public function question_adoption(Question $obj,Request $request){
        $rid = intval($request->get('id'));
        $return['code'] = 0;
        if ($rid){
            $obj->rid = $rid;
            $obj->save();
            $return['code'] = 1;
        }
        return $return;
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Question();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }


}
