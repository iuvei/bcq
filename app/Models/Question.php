<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Question extends Model
{
    protected $table = 'question';

    protected $hidden = [
        'updated_at','status','sort'
    ];

    public function answers(){

        return $this->hasMany('App\Models\QuestionAnswer','qid','id');

    }

    public function user(){

        return $this->belongsTo('App\Models\User','uid','id');

    }

    public function getQuestionList($skip,$limit,$opt){

        if (empty($limit)){
            return [];
        }
        $questionList = Question::where('status',1);

        if (isset($opt['solved'])){
            $questionList = $questionList->whereNotNull('rid');
        }
        if (isset($opt['unsolved'])){
            $questionList = $questionList->whereNull('rid');
        }
        if (isset($opt['uid'])){
            $questionList = $questionList->where('uid',$opt['uid']);
        }

        $questionList = $questionList->skip($skip)->latest()->limit($limit)->get();

        $list = [];

        if ($questionList->isEmpty()){

            return $list;

        }
        
        foreach ($questionList as $key=>$question){

            $list[$key]['id'] = $question->id;

            $list[$key]['title'] = $question->title;

            $list[$key]['describe'] = $question->describe;

            $list[$key]['price'] = $question->price;

            $list[$key]['created_at'] = $question->created_at->toDateTimeString();

            $list[$key]['time'] = $question->created_at->diffForHumans();

            if (isset($opt['is_collected'])){

                $list[$key]['is_collected'] = $this->is_collected($question->id,$opt['is_collected']);

            }

            $answers = $question->answers->where('status',1);

            if ($answers->isEmpty()){

                $list[$key]['best_answer'] = '';

                $list[$key]['comments'] = 0;

            }else{

                if (isset($question->rid)){

                    if ($answers->where('id',$question->rid)->first()) {

                        $list[$key]['best_answer'] = $answers->where('id',$question->rid)->first()->content;

                    }

                }else{

                    $list[$key]['best_answer'] = $answers->first()->content;
                }

                $list[$key]['comments'] = $answers->count();
            }
        }
        return $list;
    }

    public function getView($id){//获取浏览量

        $obj = Question::find($id);

        return $obj->f_view;
    }

    public function is_collected($qid,$uid){

        $is_collected = DB::table('question_collection')->where('uid',$uid)->where('qid',$qid)->where('status',1)->count();

        return $is_collected;
    }

    public function add_collection($qid,$uid){

        $collection = DB::table('question_collection')->where('uid',$uid)->where('qid',$qid)->first();

        if ($collection){
            if ($collection->status){
                $collection = DB::table('question_collection')->where('uid',$uid)->where('qid',$qid)->update(['status'=>0]);
            }else{
                $collection = DB::table('question_collection')->where('uid',$uid)->where('qid',$qid)->update(['status'=>1]);
            }

        }else{
            $collection = DB::table('question_collection')->insert(['uid'=>$uid,'qid'=>$qid,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        }

        if (!$collection){
            return ['code'=>0,'msg'=>'update status fail'];
        }

        return ['code'=>1,'msg'=>'update status success'];
    }


    public function getCollection($id){//获取收藏数量

        $collection = DB::table('question_collection')->where('status',1)->where('qid',$id)->count();

        return $collection;
    }

    static function newQuestion($question){

        if (!empty($question['id'])) {

            $question_obj = Question::find($question['id']);
            
            if (empty($question_obj)) {
                return ['code'=>0,'msg'=>'所编辑的问题不存在'];
            }

            unset($question['id']);  

        }else{
            $question_obj = new Question();
        }

        if (empty(trim($question['title']))){
            return ['code'=>0,'msg'=>'问题标题不得为空'];
        }

        foreach ($question as $key=>$value){
            $question_obj->$key = $value;
        }
        
        $question_obj->status = 0;
        
        $question_obj->save();

        return ['code'=>1,'msg'=>'提交成功待审核','id'=>$question_obj->id];
    }

    public function QuestionDetail($qid){ //已解决问题的详情信息 //uid指的是登录用户id

        $question_detail = Question::where('status',1)->where('id',$qid)

            ->select('id','uid','rid','title','describe','price','created_at')

            ->first();

        if (empty($question_detail)){
            return '';
        }

        $answers = $question_detail->answers->where('status',1);

        $question_detail->answer_count = $answers->count();

        $question_detail->user;

        $question_detail->user->author_info;

        $question_detail->collection_count = DB::table('question_collection')

        ->where('status',1)

        ->where('qid',$qid)

        ->count();

        foreach ($answers as $key=>$answer){

            if ($answer->id == $question_detail->rid){

                $question_detail->best_answer = $answer;

                $question_detail->best_answer->username = name_filter($answer->user->username);

                $question_detail->best_answer->author_info = $answer->user->author_info;

                $question_detail->best_answer->image = $answer->user->image;

                $question_detail->best_answer->desc = $answer->user->desc;

                $question_detail->best_answer->time = $answer->created_at->diffForHumans();
                
                unset($answers[$key]);      

                continue;
            }

            $answers[$key]->time = $answer->created_at->diffForHumans();

            $answers[$key]->author_info = $answer->user->author_info;

            $answers[$key]->username = name_filter($answer->user->username);

            $answers[$key]->image = $answer->user->image;

            $answers[$key]->desc = $answer->user->desc;

            unset($answers[$key]->user);
        }

        $question_detail->other_answers = $answers;

        unset($question_detail->answers);

        return $question_detail;
    }

    static function getUserQuestion($uid,$limit,$skip){//获取用户所有提问

        $questions = Question::where('status',1)->where('uid',$uid)->latest()->skip($skip)->limit($limit)->get();

        foreach ($questions as $key=>$question){
            $questions[$key]->comment = $question->answers->count();
            $questions[$key]->collection = $question->getCollection($question->id);
            unset($questions[$key]->answers);
        }
        return $questions;
    }

    static function deleteUserQuestion($uid,$qid){//用户删除回答

        $answer_obj = Question::where('id',$qid)->where('uid',$uid)->first();

        if (empty($answer_obj)){
            return ['code'=>0,'问题状态错误'];
        }

        $answer_obj->status = -1;

        $answer_obj->save();

        return ['code'=>1,'msg'=>'删除成功'];
    }


    static function myQuestionCount($uid){
        
        $count = Question::where('uid',$uid)->where('status',1)->count();

        return $count;
    }

    public function acceptAnswer($qid,$rid){

        $question  = Question::where('id',$qid)->first();

        if (empty($question)) {
            return ['code'=>0,'msg'=>'问题状态有误'];
        }

        $question->rid = $rid;

        $question->save();

        return ['code'=>1,'msg'=>'设为最佳答案'];

    }

    public function Search($keywords){

        $search = Question::where('status',1);              

        if(!trim($keywords)){

            $search = $search->limit(20);

        }else{

            $keywords = '%'.$keywords.'%';

            $search = $search->where('title','like',$keywords);
        }

        $search = $search

                ->select('id','uid','title','f_view as view','describe','updated_at')

                ->orderBy('view','desc')

                ->latest()

                ->limit(10)

                ->get();

        foreach ($search as $key => $value) {
            $search[$key]->time = isset($value->updated_at)?$value->updated_at->diffForHumans():'';
            $search[$key]->username = name_filter($value->user->username);
            $search[$key]->collection = $this->getCollection($value->id);   
            $search[$key]->brief = $search[$key]->describe;
            $search[$key]->comment = $value->answers->count();           
            unset($search[$key]->user);   
            unset($search[$key]->answers);  
        }

        return $search;
    }

    public function addView($id){

        $question = Question::where('id',$id)->first();

        $f_view = $question->f_view;

        $time = $question->updated_at->timestamp;     

        $time_sub = (time()-$time)/3600;

        $conf = config('base.view_config.news');

        $f_view = view_rand($f_view,$time_sub,$conf);

        DB::table('question')->where('id',$id)->increment('view');

        DB::table('question')->where('id',$id)->increment('f_view',$f_view);                

    }


    public function get_hot_question(){

        $week_ago = date('Y-m-d', strtotime('-7 days'));

        $hot_question = Question::where('status',1)

        ->where('updated_at','>',$week_ago)

        ->select('id','title')

        ->orderBy('view','desc')

        ->limit(10)

        ->get();

        return $hot_question;

    }        

    public function AssembleData($id){

        $data = Question::where('id',$id)

                ->where('status',1)

                ->select('id','title','uid','f_view','updated_at')

                ->first();
        
        if (empty($data)) {

            return false;
        }
        
        $data->time = isset($data->updated_at)?$data->updated_at->diffForHumans():'';

        $data->answer_count = $data->answers->count();

        $data->collection = $this->getCollection($id);

        if ($data->user) {
    
            $data->user_name = name_filter($data->user->username);

            $data->user_id = $data->user->id;

            $data->user_image = $data->user->image;

            unset($data->user);

        }        

        return $data;

    } 


    static function QuestionEdit($id,$uid){
        
        $data = Question::where('id',$id)->where('uid',$uid)->where('status',-2)->select('id','title','describe')->first();

        return $data;
    }
}
