<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Question;
use App\Models\AdminModels\Feedback;
use App\Models\AdminModels\User;

class FeedbackController extends Controller
{
    protected $passField = [
        'uid','title','content','addip','status'
    ];

    public function feedback_list(){
        $object = Feedback::getFeedback()->load('user');
        return view('Admin.feedback.feedback-list',compact('object'));
    }

    public function datastatus(Request $request){
        if($request->isMethod('post')){
            $idList = explode(',',request('id_list'));
            $model = new Feedback();
            $return = ToolsController::datastatus(request('status'),$idList,$model);
            return $return;
        }
    }

    public function feedback_review(){
        $object = Feedback::whereIn('status',[0,1])->get()->load('user');
        return view('Admin.feedback.feedback-list',compact('object'));
    }

    public function feedback_edit(Feedback $obj){
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'title' => 'max:40',
                'content' => 'max:200',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val)){	$val = clean($val);}
                if(in_array($key,$this->passField)){
                    $obj->$key = $val;
                }
            }
            $obj->save();
            //返回结果
        }
        return view('Admin.feedback.feedback-edit',compact('obj'));
    }
}
