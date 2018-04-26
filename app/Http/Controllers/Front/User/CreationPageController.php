<?php

namespace App\Http\Controllers\Front\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use App\Models\User;
use App\Models\AuthorClass;
use DisplaySystem;
use FileSystem;
use App\Models\News;
use App\Models\NewsCategory;
use App\Http\Controllers\Admin\ToolsController;
class CreationPageController extends Controller
{
    private $uid;//用户id

    private $user;

    private $author;

    public function __construct()
    {
        $this->middleware(function ($request,Closure $next){
            $user_info =  get_user_info();
            if ($user_info['code'] == 1){//判断用户是否登陆
                $this->author = $user_info['user'];
                $this->user = new User();
                $author_check = $this->user->authorCheck($this->author->id);//判断用户是否为作者
                if (!$author_check['code']){
                    echo json_encode($author_check);
                    die;
                }
            }else{
                echo json_encode(['code'=>0,'msg'=>'请先登陆账号']);
                die;
            }
            return $next($request);
        });
    }
    public function render(){
        //作者基础信息
        $author_info = $this->user->getUserSimpleInfo($this->author->id);

        $author_info->signature = $this->author->signature;

        $author_news = $this->user->authorCreation($this->author->id);

        $author_class = $this->user->authorCategory($this->author->id);

        $news_category = NewsCategory::getCategory('=',1,'sort');
        
        $author_news = $author_news->groupBy('status');//将创作按照状态分类 -3是未提交状态 -2是退回状态 在草稿箱 0是待审核状态 1是发布成功

/*        if(isset($author_news[1])||isset($author_news[0])||isset($author_news[-2])){*/
        if(isset($author_news[-2])||isset($author_news[-3])){

            $author_news[-2] = isset($author_news[-2])?$author_news[-2]:collect([]);

            $author_news[-3] = isset($author_news[-3])?$author_news[-3]:collect([]);
            //待审核以及发布成功的不显示
/*            $author_news[0] = isset($author_news[0])?$author_news[0]:collect([]);

            $author_news[1] = isset($author_news[1])?$author_news[1]:collect([]);*/

            $author_news[1] = $author_news[-2]->merge($author_news[-3]);
            
            $author_news[1] = $author_news[1]->groupBy('ucid');

            unset($author_news[-2]);

            unset($author_news[-3]);
        }

        $render = [
            'author_info'=>$author_info,
            'author_news'=>$author_news,
            'author_class'=>$author_class,
            'news_category'=>$news_category              
        ];

        echo json_encode($render);
    }

    public function buildNewClass(Request $request){//创建新分类

        if (!isset($this->author->id)){//判断是否是作者本人
            echo json_encode(['code'=>0,'msg'=>'用户状态错误']);
            die;
        }

        $cname = clean($request->input('cname'));//新建分类名称

        $build_ret = AuthorClass::addClass($this->author->id,$cname);

        $author_class = $this->user->authorCategory($this->author->id);

        echo json_encode($author_class);
    }

    public function deleteClass(Request $request){

        $ucid = $request->input('ucid');//要删除的分类的id

        if (!isset($this->author->id)){//判断是否是作者本人
            echo json_encode(['code'=>0,'msg'=>'用户状态错误']);
            die;
        }

        if (!$ucid) {
            
            echo json_encode(['code'=>0,'msg'=>'未选择要删除的分类']);
            
            die;
        }

        $delete_ret = AuthorClass::deleteClass($this->author->id,$ucid);

        echo json_encode($delete_ret);

    }

    public function restoreClass(Request $request){

        $ucid = $request->input('ucid');//要删除的分类的id

        if (!isset($this->author->id)){//判断是否是作者本人
            echo json_encode(['code'=>0,'msg'=>'用户状态错误']);
            die;
        }

        if (!$ucid) {
            
            echo json_encode(['code'=>0,'msg'=>'未选择要恢复的分类']);
            
            die;
        }

        $restore_ret = AuthorClass::restoreClass($this->author->id,$ucid);

        echo json_encode($restore_ret);

    }

    public function getContent(Request $request){

        $id = $request->input('id');

        $content = News::getContent($id);

        echo json_encode($content);

    }

    public function createCreation(Request $request){//保存创作

        $type = $request->input('type');//type 为 1 保存文章 或者 2 发布文章

        $creation['nid'] = $request->input('nid');

        if (empty($request->input('ucid'))) {
            echo json_encode(['code'=>0,'msg'=>'请创建并选择分类']);
            die;
        }

        if (empty(trim($request->input('title')))) {
            echo json_encode(['code'=>0,'msg'=>'请填写作品分类']);
            die;
        }

        if ($type == 2&&empty($request->input('cid'))) {
            echo json_encode(['code'=>0,'msg'=>'请选择作品分类']);
            die;
        }

        if ($request->input('image')&&$request->input('image')!='null') {
            $creation['image'] = $request->input('image');
        }

        if ($request->input('cid')) {
            $creation['cid'] = $request->input('cid');         
        }

        $creation['ucid'] = $request->input('ucid');

        $search = array("赌博", "博彩", "赌徒");
        
        $replace  = array("菠菜", "菠菜", "玩家");

        $creation['byself'] = $request->input('byself');
        
        $creation['content'] = $request->input('content')?$request->input('content'):'';

        $creation['content'] = str_replace($search,$replace,$creation['content']);

        $creation['count'] = $request->input('count')?$request->input('count'):0;

        $creation['title'] = clean($request->input('title'));

        $creation['title'] = str_replace($search,$replace,$creation['title']);

        if ($creation['content']) {
            $creation['brief'] = $creation['content']?mb_substr(strip_tags($creation['content']),0,200).'.....':$creation['title'];
        }

        if ($type == 2) {
            
            $key_res = ToolsController::getKeyword(strip_tags(html_entity_decode($creation['content'])));
            
            $creation['key_all'] = $key_res['key_all'];
            
            $creation['keywords'] = $key_res['keywords'];
        }

        $creation['author'] = 1;

        $creation['origin'] = clean($this->author->username);

        $creation['uid'] = $this->author->id;

        $save_ret = News::createCreation($creation,$type);
        
        if ($type == 2&&$save_ret['code']==1) {
            $creation['id'] = $save_ret['id'];
            $post_ret = $this->post_data($creation);
        }

        echo json_encode($save_ret);
    }

    public function post_data($creation){

        $url = config('base.post_boniu.url');

        $post_data['token'] = config('base.post_boniu.token');

        $post_data['title'] = $creation['title'];

        $post_data['brief'] = $creation['brief']?$creation['brief']:$creation['title'];

        $post_data['pic'] = $creation['image']?$creation['image']:'';

        $post_data['id'] = $creation['id'];

        $post_data['addtime'] = time();

        $post_data['content'] = $creation['content']?$creation['content']:'';

        $post_data['status'] = 0;

        $new_obj = get_model_obj('AdminModels\News');

        $ret = $new_obj::request_post($url, $post_data);
    }

    public function deleteCreation(Request $request){//删除创作

        $uid = $this->author->id;

        $nid = $request->input('nid');

        $delete_ret = News::deleteCreation($uid,$nid);

        echo json_encode($delete_ret);
    }

    public function restoreCreation(Request $request){//恢复创作

        $uid = $this->author->id;

        $nid = $request->input('nid');

        $restore_ret = News::restoreCreation($uid,$nid);

        echo json_encode($restore_ret);
    }

    public function moveCreation(Request $request){//移动创作分组

        $uid = $this->author->id;

        $nid = $request->input('nid');

        $ucid = $request->input('ucid');

        $move_ret = News::moveCreation($uid,$nid,$ucid);

        echo json_encode($move_ret);

    }

    public function renameClass(Request $request){//修改分组名称

        $uid = $this->author->id;

        $ucid = $request->input('ucid');

        $new_name = $request->input('new_name');

        $rename_ret = AuthorClass::renameClass($uid,$ucid,$new_name);

        if ($rename_ret['code']==1) {
           $rename_ret['author_class'] = $this->user->authorCategory($this->author->id);
        }

        echo json_encode($rename_ret);
    }

    public function uploadPicture(Request $request){

        $dir = 'creation/'.$this->author->id;

        $picture = $request->file('picture');

        $path_ret = FileSystem::uploadPublicFile($picture,$dir);

        echo json_encode($path_ret);
    }

    public function uploadPictureBase64(Request $request){

        $dir = 'creation/'.$this->author->id;

        $picture = $request->input('picture');

        $path_ret = FileSystem::uploadPublicFileBase64($picture,$dir);

        echo json_encode($path_ret);

    }   

    public function lock_news(Request $request){

        $id = $request->input('id');

        $ret = News::LockNews($id);

        echo json_encode($ret);

    } 

}