<?php
namespace App\Http\Controllers\Front\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DisplaySystem;
use Closure;
use App\Models\User;
use App\Models\AuthorClass;
use App\Models\Author;
use App\Models\Message as Message; 
use Cache;
use Carbon\Carbon;
use App\Http\Controllers\CommonController as Common;
class UserZoneController extends Controller
{
    private $uid;

    private $user;

    private $newsOpt;

    private $trendOpt;

    private $userDataOpt;

    private $businessOpt;

    private $platformOpt;

    private $questionOpt;

    private $microOpt;

    private $auid;

    public function __construct(Request $request)
    {
        $this->auid = $request->input('auid');//所点击用户的用户id
        //需求改变，这个页面变为个人空间，所有人都有
        if (!$this->auid){//点击进入用户的主页，所以一定会传入一个用户的id -> auid
            $this->auid = -1;
        }

        $this->newsOpt = ['order_by_update'=>1,'field'=>['View','Comment','Collection'],'uid'=>$this->auid];

        $this->trendOpt = ['field'=>['View','Comment','Collection'],'uid'=>$this->auid];

        $this->userDataOpt = ['field'=>['View','Comment','Collection'],'uid'=>$this->auid];

        $this->microOpt = ['uid'=>$this->auid];

        $this->businessOpt = ['uid'=>$this->auid,'field'=>['View']];

        $this->platformOpt = ['uid'=>$this->auid,'field'=>['View']];

        $this->questionOpt = ['uid'=>$this->auid,'field'=>['View']];

        $this->user = new User();
        
        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;

                $this->newsOpt['is_collected'] = $this->uid;

            }

            return $next($request);
        });
    }

    public function render(Request $request){ 
        //是否用户本人空间
        $is_self = isset($this->uid)&&($this->uid==$this->auid)?true:false;
        //是否用户是作者
        $is_author = Author::is_author($this->auid);

        if (isset($this->uid)) {
            $is_attention = User::is_attention($this->auid,$this->uid);            
        }else{
            $is_attention = 0;
        }
        //作者信息      
        $user_info = $this->user->getUserSimpleInfo($this->auid);
/*        if ($is_author) {
            $user_info['desc'] = Author::GetDesc($this->auid);
        }  */
        //获取作者粉丝数
        $user_info['fans'] = $this->user->getFansCount($this->auid);
        //获取发表的文章总字数
        $user_info['count'] = get_model_obj('Falls')->FallsCount($this->auid);
        //作者自定义分类
        $user_category = $is_author?AuthorClass::getClass($this->auid):[];

/*        $recently_comments = $is_author?$this->getRecentComments():[];
*/
        $recently_comments = $this->getRecentComments();     
        //获取作者关注数
        $user_info['attention'] = $this->user->getAttentionCount($this->auid);
        //作者分享的产品

        $common_obj = new Common;

        $view_total = get_model_obj('News')->getUsreView($this->auid,'','');//总点击量

        $income_total = $common_obj->IncomeComputer($view_total);//总收益

        $user_info['income'] = intval($income_total);

        $fans = $this->user->getFanList($this->auid,0,config('etc.author_page.fans.render_limit'),$this->uid);

        $attention = $this->user->getAttentionList($this->auid,0,config('etc.author_page.attention.render_limit'));

        $visitors = $this->visitor($this->auid);

        if (!$is_self&&$this->uid) {

            $ip = $request->getClientIp();

            $this->VisitorRecord($this->auid,$this->uid,$ip);
        }

        $render = [
            'is_author' => $is_author,
            'is_self' => $is_self,
            'user_info' => $user_info,
            'user_category' => $user_category,            
            'recently_comments' => $recently_comments,
            'fans' => $fans,
            'attention' => $attention,
            'is_attention'=>$is_attention,
            'visitors'=>$visitors
        ];

        echo json_encode($render);
    }


    public function GetCatList(Request $request){

        $cat = $request->input('cat');

        if ($cat == 'micro') {

            //作者发布的微动态
            $user_micro = $this->getList('Micro',0,config('etc.author_page.news.render_limit'),$this->microOpt);      

            echo json_encode($user_micro);  
        
        }elseif($cat == 'news'){

            $is_author = Author::is_author($this->auid);

            //作者发布的资讯
            $user_news = $is_author?$this->getList('News',0,config('etc.author_page.news.render_limit'),$this->newsOpt):[];

            echo json_encode($user_news);

        }elseif($cat == 'trend'){
            
            $user_trends = $this->getList('Trend',0,config('etc.author_page.trend.render_limit'),$this->trendOpt);
            
            $user_trends = $user_trends->groupBy('date')->sortByDesc('date');//按照时间分组
        
            echo json_encode($user_trends);

        }elseif($cat == 'data'){

            //用户发布的资料
            $user_data = $this->getList('UserData',0,config('etc.author_page.user_data.render_limit'),$this->userDataOpt);

            echo json_encode($user_data);

        }elseif($cat == 'business'){

            //用户发布的供求商讯
            $user_business = $this->getList('Business',0,config('etc.author_page.business.render_limit'),$this->businessOpt);

            echo json_encode($user_business);

        }elseif($cat == 'platform'){

            //用户发布的代理招商
            $user_platform = $this->getList('Platform',0,config('etc.author_page.platform.render_limit'),$this->platformOpt);

            echo json_encode($user_platform);

        }elseif($cat == 'question'){

            //用户发布的互动问答
            $user_question = $this->getList('Question',0,config('etc.author_page.question.render_limit'),$this->questionOpt);
        
            echo json_encode($user_question);
        }

    }

    public function getRecentComments(){

        $news_comments = get_model_obj('NewsComment')::getRecentComments($this->auid,0,4);

        $question_comments = get_model_obj('QuestionAnswer')::getRecentComments($this->auid,0,4);


        $report_comments = get_model_obj('ReportComment')::getRecentComments($this->auid,0,4);

        $data_comments = get_model_obj('UserDataComment')::getRecentComments($this->auid,0,4);

        $micro_comments = get_model_obj('MicroComment')::getRecentComments($this->auid,0,4);

        $comment = $news_comments->merge($question_comments)
                    ->merge($report_comments)
                    ->merge($data_comments)
                    ->merge($micro_comments);

        $comment = $comment->sortByDesc('created_at')->values()->take(4)->all();              

        return $comment;
    }

    public function getNewsList(Request $request){

        $page = $request->input('page');

        $ucid = $request->input('ucid');

        $this->newsOpt['ucid'] = $ucid;

        $page_info = page_helper($page,config('etc.author_page.news.render_limit'),config('etc.author_page.news.limit'));

        $author_news = $this->getList('News',$page_info['skip'],$page_info['limit'],$this->newsOpt);

        echo json_encode($author_news);
    }

    public function getDataList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.author_page.user_data.render_limit'),config('etc.author_page.user_data.limit'));

        $data = $this->getList('UserData',$page_info['skip'],$page_info['limit'],$this->userDataOpt);

        echo json_encode($data);
    }

    public function getBusinessList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.author_page.business.render_limit'),config('etc.author_page.business.limit'));

        $data = $this->getList('Business',$page_info['skip'],$page_info['limit'],$this->businessOpt);

        echo json_encode($data);
    }

    public function getPlatformList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.author_page.platform.render_limit'),config('etc.author_page.platform.limit'));

        $data = $this->getList('Platform',$page_info['skip'],$page_info['limit'],$this->platformOpt);

        echo json_encode($data);
    }

    public function getQuestionList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.author_page.question.render_limit'),config('etc.author_page.question.limit'));

        $data = $this->getList('Question',$page_info['skip'],$page_info['limit'],$this->questionOpt);

        echo json_encode($data);
    }

    public function getTrendList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.author_page.trend.render_limit'),config('etc.author_page.trend.limit'));     

        $author_trends = $this->getList('Trend',$page_info['skip'],$page_info['limit'],$this->trendOpt);

        $author_trends = $author_trends->groupBy('date')->sortByDesc('date');//按照时间分组

        echo json_encode($author_trends);
    }

    public function getMicroList(Request $request){

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.author_page.news.render_limit'),config('etc.author_page.news.limit'));   

        $micro = $this->getList('Micro',$page_info['skip'],$page_info['limit'],$this->microOpt);

        echo json_encode($micro);   

    }

    public function getCommentList(Request $request){//获取作者所有评论

        $page = $request->input('page');

        $render_limit = config('etc.author_page.comment.render_limit');

        $page_limit = config('etc.author_page.comment.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);

        $news_comments = get_model_obj('NewsComment')::getRecentComments($this->auid,$page_info['skip'],$page_info['limit']);

        $question_comments = get_model_obj('QuestionAnswer')::getRecentComments($this->auid,$page_info['skip'],$page_info['limit']);

/*        $report_comments = get_model_obj('ReportComment')::getRecentComments($this->auid,$page_info['skip'],$page_info['limit']);

        $data_comments = get_model_obj('UserDataComment')::getRecentComments($this->auid,$page_info['skip'],$page_info['limit']);*/

        $comment = $news_comments->merge($question_comments);

/*                    ->merge($report_comments)

                    ->merge($data_comments);*/

        $comment = $comment->sortByDesc('created_at')->values()->all();
        
        echo json_encode($comment);
    }

    public function getFansList(Request $request){

        $page = $request->input('page');

        $render_limit = config('etc.author_page.fans.render_limit');

        $page_limit = config('etc.author_page.fans.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);

        $fans = $this->user->getFanList($this->auid,$page_info['skip'],$page_info['limit']);

        echo json_encode($fans);
    }

    public function getAttentionList(Request $request){

        $page = $request->input('page');

        $render_limit = config('etc.author_page.attention.render_limit');

        $page_limit = config('etc.author_page.attention.limit');

        $page_info = page_helper($page,$render_limit,$page_limit);

        $attention = $this->user->getAttentionList($this->auid,$page_info['skip'],$page_info['limit']);

        echo json_encode($attention);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

    public function sendMessage(Request $request){
        if (!isset($this->uid)){
            echo  json_encode(['code'=>0,'msg'=>'请先登录账号']);
            die;
        }
        $to = $request->input('to');

        $content = $request->input('content');
 
        $msg_obj = new Message();

        $send_ret = $msg_obj->sendMessage($this->uid,$to,$content);

        echo json_encode($send_ret);
    }

    public function VisitorRecord($auid,$vuid,$ip){

        $cache_key = 'visit-'.$auid.'-'.$vuid;

        Cache::get($cache_key, function() use ($auid,$vuid,$cache_key){

            $v_obj = get_model_obj('Visitor');

            $v_obj->auid = $auid;

            $v_obj->vuid = $vuid;

            $v_obj->save();

            $expire_time = Carbon::tomorrow();

            Cache::put($cache_key,1,$expire_time);

        });        
    }


    public function visitor($auid){

        $v_obj = get_model_obj('Visitor');

        $visitors = $v_obj->GetVisitor($auid);

        foreach($visitors as $key=>$visitor){

            $visitors[$key]->is_author = Author::is_author($visitor->vuid);

        }

        return $visitors;
    }
}