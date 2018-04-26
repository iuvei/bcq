<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
class QuestionAnswer extends Model
{
    //
    protected $table = 'question_answer';

    protected $hidden = [
        'updated_at','status','sort'
    ];

    public function user(){

        return $this->belongsTo('App\Models\User','uid','id');

    }

    public function question(){

        return $this->belongsTo('App\Models\Question','qid','id');

    }
/*
    public function commentable(){

        return $this->morphMany('App\Models\UserComment','commentable');
    }*/


    static function addAnswer($answer){

        $answer_obj = new QuestionAnswer();

        if (empty($answer['uid'])){

            return ['code'=>0,'msg'=>'请先登录'];

        }elseif (empty($answer['qid'])){

            return ['code'=>0,'msg'=>'问题状态有误'];

        }elseif (empty($answer['content'])){

            return ['code'=>0,'msg'=>'答案内容不得为空'];

        }

        foreach ($answer as $key=>$value){
            $answer_obj->$key = $value;
        }

        $answer_obj->save();

        return ['code'=>1,'msg'=>'提交答案成功'];

    }

    static function getUserAnswer($uid,$limit,$skip){//获取用户所有回答

        $answers = QuestionAnswer::where('status',1)->where('uid',$uid)->skip($skip)->limit($limit)->latest()->get();

        foreach ($answers as $key=>$answer){

            $answers[$key]->question = $answer->question;

            $answers[$key]->question->comment =  $answer->question->answers->count();

            $answers[$key]->question->collection = $answer->question->getCollection($answer->question->id);

            if ($answer->id == $answer->question->rid){

                $answers[$key]->accept = 1;

            }else{

                $answers[$key]->accept = 0;

            }
        }
        return $answers;
    }

    static function myAnswerCount($uid){
        
        $count = QuestionAnswer::where('uid',$uid)->count();

        return $count;       
    }

    static function getRecentComments($aid,$skip,$limit,$opt = []){
        
        $comments = DB::table('question')
            ->join('question_answer','question.id','=','question_answer.qid')
/*            ->join('users','question_answer.uid','=','users.id')*/
            ->where('question_answer.uid',$aid)
            ->where('question.status',1)
            ->where('question_answer.status',1)
            ->select('question.id as nid','question.title','question_answer.id as cid','question_answer.content','question_answer.created_at')
            ->orderBy('question_answer.created_at','desc');

        if (!empty($limit)) {
            $comments = $comments->skip($skip)->limit($limit);
        }

        $comments = $comments->get();

        foreach ($comments as $key=>$comment){

            $comments[$key]->time = Carbon::parse($comment->created_at)->diffForHumans();

            $comments[$key]->created_at = strtotime($comments[$key]->created_at);

            $comments[$key]->type = 2;
        }

        return $comments;
    }

}
