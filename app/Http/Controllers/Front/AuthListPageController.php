<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DisplaySystem;
use App\Http\Controllers\CommonController as Common;
use Closure;
class AuthListPageController extends Controller
{

    protected $uid;

    protected $hotOpt = ['recommend'=>1,'recent_news'=>1];

    protected $recentOpt = ['recent'=>1,'recent_news'=>1];

    public function __construct(Request $request){

        $this->middleware(function ($request,Closure $next){

            $user_info =  get_user_info();

            if ($user_info['code'] == 1){

                $this->uid = $user_info['user']->id;
                //登陆后才显示关注状态
                $this->hotOpt = ['recommend'=>1,'is_attention'=>$this->uid,'recent_news'=>1];

                $this->recentOpt = ['recent'=>1,'is_attention'=>$this->uid,'recent_news'=>1];
            }

            return $next($request);

        });
    }

    public function render(Request $request){

        $type = $request->input('type');

        $page = $request->input('page');

        $page_info = page_helper($page,config('etc.auth_list.author.render_limit'),config('etc.auth_list.author.limit'));

        if ($type == 1) {

            $authorList = $this->getList('Author',$page_info['skip'],$page_info['limit'],$this->hotOpt);
        
        }else{
        
            $authorList = $this->getList('Author',$page_info['skip'],$page_info['limit'],$this->recentOpt);
        
        }

        $render = [
            'authorList'=>$authorList
        ];

        echo json_encode($render);
    }

    public function getList($model,$skip,$limit,$opt = []){

        $lists = DisplaySystem::getList($model,$skip,$limit,$opt);

        return $lists;
    }

}