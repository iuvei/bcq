<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AdvertisingSystem;
use FileSystem;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Closure;
class QuestionPageController extends Controller
{

    protected $user = '';

    protected $solvedOpt = ['solved'=>1,'field'=>['Collection']];

    protected $unSolvedOpt = ['unsolved'=>1,'field'=>['Collection']];

    public function __construct(Request $request){

        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->user = $user_info['user'];

                $this->solvedOpt = ['solved'=>1,'is_collected'=>$this->user->id,'field'=>['Collection']];

                $this->unSolvedOpt = ['unsolved'=>1,'is_collected'=>$this->user->id,'field'=>['Collection']];

            }
            return $next($request);

        });
    }

    public function render(){

        $adsList = AdvertisingSystem::getAds(config('etc.question.page_id'));//获取该页所有广告位广告信息

        $getSolvedList = $this->getList('Question',0,config('etc.question.question.render_limit'),$this->solvedOpt);

        $getUnsolvedList = $this->getList('Question',0,config('etc.question.question.render_limit'),$this->unSolvedOpt);

        $questionCount = 0;
        
        $answerCount = 0;

        if (isset($this->user->id)) {
            $questionCount = Question::myQuestionCount($this->user->id);
            $answerCount = QuestionAnswer::myAnswerCount($this->user->id);           
        }

        $render = [
            'adsList'=>$adsList,
            'getUnsolvedList'=>$getUnsolvedList,
            'getSolvedList'=>$getSolvedList,
            'user'=>$this->user,
            'questionCount'=>$questionCount,
            'answerCount'=>$answerCount
        ];

        echo json_encode($render);

    }

    public function getMore(Request $request){

        if ($request->input('type')=='solved') {
            $opt = $this->solvedOpt;
        }else{
            $opt = $this->unSolvedOpt;
        }

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.question.question.render_limit'),config('etc.question.question.limit'));

        $DataList = $this->getList('Question',$page_info['skip'],$page_info['limit'],$opt);

        echo json_encode($DataList);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }


    public function addQuestionCollection(Request $request){

        $qid = $request->input('qid');

        $common = new Common();

        $ret = $common->Collection('Question',$qid);

        echo json_encode( $ret);
    }

    public function questionSearch(Request $request){

        $question = $request->input('question');

        $question = Question::search($question);

        echo json_encode($question);
    }

    public function newQuestion(Request $request){

        if (!$this->user){//判断用户是否登陆
            echo json_encode(['code'=>0,'msg'=>'请先登陆']);
            die;
        }

        $question['uid'] = $this->user->id;

        if (!empty($request->input('id'))) {
            
            $question['id'] = clean($request->input('id'));

        }
        
        $question['title'] = clean($request->input('title'));

        $question['describe'] = clean($request->input('describe'));

        $question['price'] = config('base.price.question');

        $question_ret = Question::newQuestion($question);

/*        if ($question_ret['code']&&$this->user->level_id>2) {
            
            get_model_obj('Falls')->InsetToFalls('Question',$question_ret['id'],$question['title']);
        
        }*/

        echo json_encode($question_ret);
    }

    public function newQuestionRender(Request $request){

        $id = $request->input('id');

        $uid = $this->user->id;

        if (!$id||!$uid) {
            $data = '';
        }else{
            $data = Question::QuestionEdit($id,$uid);
        }
        echo json_encode($data);
    }
}