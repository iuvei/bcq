<?php
namespace App\Http\Controllers\Admin;

use App\Models\AdminModels\Data;
use App\Models\AdminModels\Question;
use App\Models\AdminModels\Trends;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModels\News;
use App\Models\AdminModels\Business;
use App\Models\AdminModels\Platform;
use App\Models\AdminModels\DataComment;
use App\Models\AdminModels\NewsComment;
use App\Models\AdminModels\AnswerComment;
use App\Models\AdminModels\ReportComment;
use App\Models\AdminModels\TrendsComment;
use App\Models\AdminModels\ApplicantAuth;
use App\Models\AdminModels\Feedback;

class IndexController extends Controller
{
    protected $count;

    public function __construct(){
        $this->count = [
            'news' => News::where('status',0)->count(),
            'trends' => Trends::where('status',0)->count(),
            'data' => Data::where('status',0)->count(),
            'business1' => Business::where('type',1)->where('status',0)->count(),
            'business2' => Business::where('type',2)->where('status',0)->count(),
            'platform1' => Platform::where('type',1)->where('status',0)->count(),
            'platform2' => Platform::where('type',2)->where('status',0)->count(),
            'question' => Question::where('status',0)->count(),
            'data_comment' => DataComment::where('complaint','<>',0)->count(),
            'news_comment' => NewsComment::where('complaint','<>',0)->count(),
            'question_answer_comment' => AnswerComment::where('complaint','<>',0)->count(),
            'report_comment' => ReportComment::where('complaint','<>',0)->count(),
            'trends_comment' => TrendsComment::where('complaint','<>',0)->count(),
            'applicant_author' => ApplicantAuth::where('status',0)->count(),
            'feedback' => Feedback::where('status',0)->count(),
        ];
    }

    public function index(){
        $user = Auth::user();
        $count = $this->count;
        $total = array_sum($this->count);
        return view('Admin.index.welcome',compact('user','count','total'));
    }

    public function tips(){
        $count = $this->count;
        return view('Admin.index.tips',compact('count'));
    }

    public function getCount(){
        $count = array_sum($this->count);
        return $count;
    }
}
