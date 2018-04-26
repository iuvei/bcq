<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\PriceRecord;
use App\Http\Controllers\CommonController as Common;
class QuestionDetailPageController extends Controller //问答详情页
{
    private $user;

    private $question_obj;

    private $answer_obj;

    protected $common_obj;

    public function __construct()
    {
        $this->question_obj = new Question();

        $this->answer_obj = new QuestionAnswer();

        $this->common_obj = new Common();        

        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->user = $user_info['user'];

            }

            return $next($request);
        });
    }

    public function render(Request $request){//已解决问题详情页

        $qid = $request->input('qid');

        if (!$qid) {

            dd('status error');
        
        }

        $ip = $request->getClientIp();

        $this->common_obj->addView('Question',$qid,$ip);

        $solved_detail = $this->question_obj->QuestionDetail($qid);

        if (empty($solved_detail)) {
            echo '';
            die;
        }

        if (!empty($solved_detail)&&isset($this->user->id)&&$this->user->id==$solved_detail->uid) {
            $solved_detail->is_self = $this->user->id;
        }else{
            $solved_detail->is_self = 0;
        }

        echo json_encode($solved_detail);
    }


    public function answerQuestion(Request $request){//回答问题

        if (!isset($this->user->id)) {
            echo json_encode(['code'=>0,'msg'=>'请先登录账号']);
            die;
        }

        $answer['uid'] = $this->user->id;

        $answer['qid'] = $request->input('qid');

        $answer['content'] = clean($request->input('content'));

        $answer_ret = QuestionAnswer::addAnswer($answer);

        $answer_ret['user_info'] = $this->user;   

        echo json_encode($answer_ret);

    }

    public function userQuestion(Request $request){

        $page = $request->input('page');

        $type = $request->input('type');

        $page_info = page_helper($page,config('etc.question_detail.user_question.render_limit'),config('etc.question_detail.user_question.limit'));

        if ($type == 'question') {

            $user_ret = Question::getUserQuestion($this->user->id,$page_info['limit'],$page_info['skip']);

        }else{

            $user_ret = QuestionAnswer::getUserAnswer($this->user->id,$page_info['limit'],$page_info['skip']);
        }

        echo json_encode($user_ret);
    }

/*    public function userQuestion(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.question_detail.user_questions.render_limit'),config('etc.question_detail.user_questions.limit'));

        echo json_encode($user_question);
    }*/


    public function deleteUserQuestion(Request $request){

        $qid = $request->input('qid');//answer的主键id

        $delete_ret = Question::deleteUserQuestion($this->user->id,$qid);

        echo json_encode($delete_ret);
    }

    public function acceptAnswer(Request $request){

        $qid = $request->input('qid');
        
        $rid = $request->input('rid');

        $price = config('base.price.question');

        $auid = $this->answer_obj->where('id',$rid)->first()->uid;

        $price_set = $this->user->setNewPrice($auid,$price,'add');

        PriceRecord::record($auid,3,$qid,$price);

        $ret = $this->question_obj->acceptAnswer($qid,$rid);

        $ret['price_set'] = $price_set['msg'];

        echo json_encode($ret);
    }

}
