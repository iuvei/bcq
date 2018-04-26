<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\News;
use App\Models\AdminModels\NewsCategory;
use App\Models\AdminModels\Author;
use App\Models\AdminModels\User;
use App\Models\AdminModels\Fall;
use App\Models\AdminModels\Message;
use App\Models\AdminModels\Key;
use App\Http\Controllers\Admin\ToolsController;

class NewsController extends Controller
{
    protected $category;
    protected $passField = [
        'uid','cid','ucid','count','sort','view','title','origin','author','image','key_all','keywords','brief','content','byself','status'
    ];
    protected $author;


    public function __construct()
    {
        $this->category = NewsCategory::getCategory('!=',-1,'created_at');
        $this->author = User::getUserAuthor();
    }

    public function news_list(Request $request){
        if($request->isMethod('post')){
            $sSearch = $request->post('sSearch')?$request->post('sSearch'):'';
            $orOpt = array();
            if ($sSearch){
                $orOpt['title'] = array('like','%'.$sSearch.'%');
                $orOpt['keywords'] = array('like','%'.$sSearch.'%');
                $orOpt['content'] = array('like','%'.$sSearch.'%');
            }

            $betweenOpt = array();
            if ($request->post('datemin') && $request->post('datemax')){
                $betweenOpt['created_at'] = array($request->post('datemin'),$request->post('datemax'));
            }
            $object = News::getNews(0,10,true,$orOpt,$betweenOpt);
        }else{
            $object = array();
        }
        $category = $this->category;
        return view('Admin.news.news-list',compact('object','category'));
    }

    public function news_ajax_list(Request $request){
        $orOpt = array();
        if ($request->get('sSearch')){
            $sSearch = $request->get('sSearch')?$request->get('sSearch'):'';
            $orOpt['title'] = array('like','%'.$sSearch.'%');
            $orOpt['keywords'] = array('like','%'.$sSearch.'%');
            $orOpt['content'] = array('like','%'.$sSearch.'%');
        }

        $object = News::getNews($request->get('iDisplayStart'),$request->get('iDisplayLength'),false,$orOpt);
        $Data = array(
            'aaData' => $object,
            'iTotalRecords' => count($object),
        );

        if ($request->get('sSearch')) {//如果有全局搜索，搜索出来的个数
            $Data['iTotalDisplayRecords'] = count($object);
        } else {
            $count = News::getNewsCount();
            $Data['iTotalDisplayRecords'] = $count;
        }
        return json_encode($Data);

        //dd($object['data']);
        //return view('Admin.user.user-list', compact('user'));
    }

    public function news_review(Request $request){
        $object = News::where('status', 0)->get();
        $category = $this->category;
        return view('Admin.news.news-list',compact('object','category'));
    }

    public function news_add(Request $request){
        if($request->isMethod('post')){
            //验证
            $this->validate(request(), [
                'cid' => 'required',
                'sort' => 'integer',
                'view' => 'integer',
                'title' => 'required|max:40',
                'uid' => 'required',
                'brief' => 'required|max:210',
                'content' => 'required',
                'byself' => 'required',
                'status' => 'required',
            ]);

            //数据库操作
            $data = [];
            foreach ($request->all() as $key => $val){
                if (!is_numeric($val) && $key != 'content'){$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'brief' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $data[$key] = $val;
                }
            }

            $key_res = ToolsController::getKeyword(strip_tags(html_entity_decode($data['content'])));
            $data['key_all'] = $key_res['key_all'];
            $data['keywords'] = $key_res['keywords'];

            if($data['keywords']){
                $key_arr = explode(',',$data['keywords']);
                foreach ($key_arr as $val){
                    Key::firstOrCreate(
                        ['keywords' => $val]
                    );
                }
            }

            $data['count'] = mb_strlen(strip_tags($data['content']));
            if ($new = News::create($data)){
                $authorData['u_time'] = time();
                $authorData['publish'] = News::getAuthorNewsCount($data['uid']);

                Author::where('uid',$data['uid'])->update($authorData);
                $url = config('base.post_boniu.url');
                $post_data['token'] = config('base.post_boniu.token');
                $post_data['title'] = $data['title'];
                $post_data['brief'] = $data['brief']?$data['brief']:$data['title'];
                $post_data['pic'] = $data['image'];
                $post_data['id'] = $new->id;
                $post_data['addtime'] = strtotime($new->created_at);
                $post_data['content'] = $data['content'];
                $post_data['status'] = $data['status'];
                News::request_post($url, $post_data);
                if ($data['uid'] == 1593){
                    $post_data['image'] = $data['image']?$data['image']:'';
                    $res = News::request_post(config('base.post_betconsult.url'), $post_data);
                    dd($res);
                }
            }
        }

        //返回结果
        $category = $this->category;
        $author = $this->author;
        return view('Admin.news.news-add',compact('category','author'));
    }

    public function news_edit(News $obj){
        $oldStatus = $obj->status;
        if(request() ->isMethod('post')){
            //验证
            $this->validate(request(), [
                'cid' => 'required',
                'sort' => 'integer',
                'view' => 'integer',
                'title' => 'required|max:40',
                'uid' => 'required',
                'brief' => 'required|max:210',
                'content' => 'required',
                'byself' => 'required',
                'status' => 'required',
            ]);
            //数据库操作
            foreach (request()->all() as $key => $val){
                if (!is_numeric($val) && $key != 'content'){$val = clean($val);}
                if(in_array($key,$this->passField)){
                    if($key == 'title' || $key == 'brief' || $key == 'content'){
                        $val = str_replace(config('base.find'),config('base.replace'),$val);
                    }
                    $obj->$key = $val;
                }
            }

            if($obj->keywords){
                $key_arr = explode(',',$obj->keywords);
                foreach ($key_arr as $val){
                    Key::firstOrCreate(
                        ['keywords' => $val]
                    );
                }
            }
            $obj->count = mb_strlen(strip_tags($obj->content));

            if($obj->save()){
                if (intval($obj->status) == 1 && intval($oldStatus) == 0){
                    Fall::updateOrCreate(
                        ['title' => $obj->title,'uid' => $obj->uid,'cid' => $obj->id, 'model' => 'News','status' => 1],
                        ['updated_at' => date('Y-m-d H:i:s')]
                    );
                    Message::create(
                        ['from' => 1,'to' => $obj->uid,'status' => 1,'content' => "你于产业资讯 $obj->created_at 发布的内容，已在".date('Y-m-d H:i:s')." 审核通过，期待你发布更多的产业相关动态。"]
                    );
                }elseif (intval($obj->status) != 1){
                    Fall::where(['cid' => $obj->id])
                        ->where(['model' => 'News'])
                        ->update(
                            ['status' => 0]
                        );
                }
                $authorData['u_time'] = time();
                $authorData['publish'] = News::getAuthorNewsCount($obj->uid);

                Author::where('uid',$obj->uid)->update($authorData);
                $url = config('base.post_boniu.url');
                $post_data['token'] = config('base.post_boniu.token');
                $post_data['title'] = $obj->title;
                $post_data['brief'] = $obj->brief?$obj->brief:$obj->title;
                $post_data['pic'] = $obj->image;
                $post_data['id'] = $obj->id;
                $post_data['addtime'] = strtotime($obj->updated_at);
                $post_data['content'] = $obj->content;
                $post_data['status'] = $obj->status;
                News::request_post($url, $post_data);
                if ($obj->uid == 1593){
                    $post_data['image'] = $obj->image?$obj->image:'';
                    $res = News::request_post(config('base.post_betconsult.url'), $post_data);
                    dd($res);
                }
            }
        }

        //返回结果
        $category = $this->category;
        $author = $this->author;
        $obj = $obj->load('user');
        $table = $obj->getTable();
        return view('Admin.news.news-edit',compact('obj','table','category','author'));
    }

    public function datastatus(Request $request)
    {
        $status = request('status');
        $id_str = request('id_list');
        if ($request->isMethod('post')) {
            $idList = explode(',', $id_str);

            $return_data['code'] = '-1';
            $return_data['msg'] = '系统错误，请稍候再试！';
            if (!empty($idList)) {
                switch ($status) {
                    case -1:
                        $data['status'] = -1;
                        break;
                    case 0:
                        $data['status'] = 0;
                        break;
                    case 1:
                        $data['status'] = 1;
                        break;
                    default:
                        return json_encode($return_data);
                }

                $res = News::whereIn('id', $idList)->update($data);

                if ($res !== false) {
                    foreach ($idList as $key => $val){
                        $newsRes = News::select('uid')->where('id',$val)->first();
                        $authorData['u_time'] = time();
                        $authorData['publish'] = News::getAuthorNewsCount($newsRes->uid);
                        Author::where('uid',$newsRes->uid)->update($authorData);
                    }
                    $id_str = implode(',',$idList);
                    $url = config('base.post_boniu.url2');
                    $post_data['token'] = config('base.post_boniu.token');
                    $post_data['id'] = $id_str;
                    $post_data['status'] = $status;
                    News::request_post($url, $post_data);

                    $return_data['code'] = '1';
                    $return_data['msg'] = '成功';
                } else {
                    $return_data['code'] = '-1';
                    $return_data['msg'] = '系统错误，请稍候再试！';
                }
                return $return_data;
            }
        }
    }


}
