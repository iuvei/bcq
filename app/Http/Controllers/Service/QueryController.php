<?php
namespace App\Http\Controllers\Service;
ini_set("max_execution_time",  0);

//use Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use QL\QueryList;
use QL\Ext\AbsoluteUrl;
use QL\Ext\PhantomJs;
use App\Models\AdminModels\Flash;
use App\Models\AdminModels\Fall;
use App\Models\AdminModels\News;
use App\Models\AdminModels\Author;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\HttpKernel\Tests\Controller\controller_function;
use function Symfony\Component\HttpKernel\Tests\controller_func;
use App\Http\Controllers\Admin\ToolsController;


class QueryController extends Controller
{
    protected $file;
    protected $redis;
    protected $disk_obj;
    protected $model;

    public function __construct()
    {
//        Redis::del('flash_data','url');
//        dd('redis 删除成功!');

        $this->disk_obj = Storage::disk('public');
        $this->model = new Flash();

        QueryList::use([  // 注册插件
            AbsoluteUrl::class, // 转换URL相对路径到绝对路径
        ]);
    }

    public function getHttpStatus($url){
        // 1.初始化一个curl会话资源
        $ch = curl_init();
        // 2.设置curl会话的选项
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);    // 强制使用 HTTP/1.0
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);    // 发起连接前等待超时的时间，如果设置为0，则无限等待
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);    // 设置curl允许执行的最长秒数
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    // 是否将curl_exec()获取的信息返回，而不是直接输出
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');    // 设置HTTP请求头中"Accept-Encoding: "的值
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);    // 启用时会将服务器返回的"Location: "放在header中递归的返回给服务器
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);    // 设置HTTP重定向的最大数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // 是否需要进行服务端的SSL证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    // 是否验证服务器SSL证书中的公用名
        curl_setopt($ch, CURLOPT_HEADER, false);    // 是否抓取头文件的信息
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);        // 设置HTTP请求头
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_URL, $url);    // 设置需要请求的URL地址，也可以在 curl_init()函数中设置
        // 3.执行curl会话
        curl_exec($ch);
        $res = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        // 4.关闭curl会话，释放资源
        curl_close($ch);
        return $res;
    }

    public function factoryImg($url,$km){
        $image = '';
        if (intval($this->getHttpStatus($url)) == 200){
            try {
                $client = new \GuzzleHttp\Client(['verify' => false]);  //忽略SSL错误
                $image_data = $client->request('get',$url)->getBody()->getContents();
                $date = date('Ymd');
                $dir = 'image'.DIRECTORY_SEPARATOR.$date.DIRECTORY_SEPARATOR;
                if (!$this->disk_obj->exists($dir)){
                    $this->disk_obj->makeDirectory($dir);
                }
                $image_name = md5($km.time()).'.png';
                if(file_exists(public_path().DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$dir.$image_name) || $this->disk_obj->put($dir.$image_name, $image_data)){
                    $image = DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$dir.$image_name;
                }
            } catch (\GuzzleHttp\RequestException $e) {
            }
        }
        return $image;
    }

    public function redis_set($data){
        $hash_array = [];
        $set_array = [];
        foreach ($data as $val){
            $k = $val['url'];
            if(Redis::sIsMember('url',$k)){//近期提交过
                Redis::hDel('flash_data',$k);
            }else{
                $hash_array[$k] = serialize($val);
                $set_array[] = $k;
            }
        }
        if ($hash_array){
            Redis::hMSet('flash_data',$hash_array);
        }
        if ($set_array){
            Redis::sAdd('url', $set_array);
        }
    }

    public function getData($page,$page_header,$reg,$rang,$uid){
        $data = array();
        if ($this->getHttpStatus($page) == 200){
            $ql = QueryList::get($page)->rules($reg)->range($rang)->query();
            $data = $ql->getData(function ($item) use($ql,$page_header,$uid){
                //使用帮助函数单独转换某个链接
                $item['uid'] = $uid;
                $item['image'] = isset($item['image'])?$item['image']:'';
                $item['title'] = str_replace(config('base.find'),config('base.replace'),$item['title']);
                $item['brief'] = str_replace(config('base.find'),config('base.replace'),$item['brief']);
                $item['url'] = urldecode($ql->absoluteUrlHelper($page_header,$item['url']));
                $item['created_at'] = date('Y-m-d H:i:s');
                $item['updated_at'] = date('Y-m-d H:i:s');
                return $item;
            })->all();
        }

        if ($data){
            $this->redis_set($data);
        }
    }

    public function getJsData($page,$page_header,$reg,$rang,$uid){
        $data = array();
        if ($this->getHttpStatus($page) == 200){
            $html = QueryList::getInstance()->use(PhantomJs::class,storage_path('phantomjs').'/bin/phantomjs','browser')->browser($page)->removeHead()->getHtml();


            $ql = QueryList::html($html)->rules($reg)->range($rang)->query();

            $data = $ql->getData(function ($item) use($ql,$page_header,$uid){
                //使用帮助函数单独转换某个链接

                $item['uid'] = $uid;
                $item['image'] = isset($item['image'])?$item['image']:'';
                $item['title'] = str_replace(config('base.find'),config('base.replace'),$item['title']);
                $item['brief'] = str_replace(config('base.find'),config('base.replace'),$item['brief']);
                $item['url'] = urldecode($ql->absoluteUrlHelper($page_header,$item['url']));
                $item['created_at'] = date('Y-m-d H:i:s');
                $item['updated_at'] = date('Y-m-d H:i:s');
                return $item;
            })->all();
        }
        if ($data){
            $this->redis_set($data);
        }
    }

    public function getContent($url,$page_header,$content_reg,$content_rang,$content_img_replace){
        if ($this->getHttpStatus($url) == 200){
            $content = QueryList::get($url)->rules($content_reg)->range($content_rang)->query()->getData()->first();
            $content = str_replace($content_img_replace,'src="'.$page_header,$content['content']);
            return $content;
        }
    }

    public function getJsContent($url,$page_header,$content_reg,$content_rang,$content_img_replace){
        if ($this->getHttpStatus($url) == 200){
            $html = QueryList::getInstance()->use(PhantomJs::class,storage_path('phantomjs').'/bin/phantomjs','browser')->browser($url)->removeHead()->getHtml();

            $content = QueryList::html($html)->rules($content_reg)->range($content_rang)->query()->getData()->first();
            $content = str_replace($content_img_replace,'src="'.$page_header,$content['content']);
            return $content;
        }
    }

    /*采集方法 start*/
    public function wgi8(){
        $uid = 1886;
        //需要采集的目标页面
        $page = 'https://www.wgi8.com';
        $page_header = 'https://www.wgi8.com/';
        //采集规则
        $reg = [
            'image' => ['.img-scale a img','src','',function($image) use($page_header){
                $image = $page_header.ltrim($image,'/');
                return $image;
            }],
            'url' => ['.ls-info h2 a','href'],
            'title' => ['.ls-info h2 a','text'],
            'brief' => ['',''],
        ];
        $rang = '.list-style-01 .bline';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

    public function winner365(){
        $uid = 1887;
        //需要采集的目标页面
        $page = 'http://www.365winner.biz/Article_List.aspx?p=1&id=48';
        $page_header = 'http://www.365winner.biz/';
        //采集规则
        $reg = [
            'url' => ['.gambling_tips_list dl dt .clearAll a','href'],
            'title' => ['.gambling_tips_list dl dt .clearAll a','text'],
            'brief' => ['.gambling_tips_list dl dd','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

    public function mm1396(){
        $uid = 1888;
        //需要采集的目标页面
        $page = 'https://www.1396mm.com/article/information/1.html';
        $page_header = 'https://www.1396mm.com/';
        //采集规则
        $reg = [
            'image' => ['.PTAndNList_img a img','src','',function($image){
                $image = ltrim($image,'/');
                return $image;
            }],
            'url' => ['.bw_PTAndNList_info .bw_PTAndNList_info_d .clearBoth .PTAndNL_i_title a','href'],
            'title' => ['.bw_PTAndNList_info .bw_PTAndNList_info_d .clearBoth .PTAndNL_i_title a','text'],
            'brief' => ['.bw_PTAndNList_info .bw_PTAndNList_info_d .clearBoth .PTAndNL_i_content','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '.bw_PTAndNList ul li';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

    public function mlc365(){
        $uid = 1889;
        //需要采集的目标页面
        $page = 'https://www.mlc365.com/news/';
        $page_header = '';

        //采集规则
        $reg = [
            'image' => ['.text-center .text-danger a img','src','',function($image){
                $image = 'http://www.mlc365.com'.$image;
                return $image;
            }],
            'url' => ['.h3 a','href'],
            'title' => ['.h3 a','text'],
            'brief' => ['.yh-nei','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '.container .youhui-list';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

//    public function imastv(){
//        //需要采集的目标页面
//        $page = 'http://www.imastv.com/news/index.shtml';
//        $page_header = 'http://www.imastv.com/';
//
//        //采集规则
//        $reg = [
//            'url' => ['dl dd h3 a','href'],
//            'title' => ['dl dd h3 a','text'],
//            'brief' => ['dl dd p','text','',function($brief){
//                $brief = str_limit($brief,150,'...');
//                return $brief;
//            }],
//        ];
//        $rang = '.news_notice_bd .news_notice2';
//        $this->getData($page,$page_header,$reg,$rang);
//    }

//    public function kbet(){
//        //需要采集的目标页面
//        $page = 'http://www.kbet.com/news.php?pid=20170104091250&cid=20170104091346';
//        $page_header = 'http://www.kbet.com/';
//
//        //采集规则
//        $reg = [
//            'url' => ['article header h5 a','href'],
//            'title' => ['article header h5 a','text'],
//            'brief' => ['',''],
//        ];
//        $rang = '.news_hold .new-box';
//        $this->getData($page,$page_header,$reg,$rang);
//    }

    public function ultraegaming(){
        $uid = 1890;
        //需要采集的目标页面
        $page = 'http://www.ultraegaming.com/category/产业动态/';
        $page_header = '';

        //采集规则
        $reg = [
            'image' => ['.list-article-thumb a img','src'],
            'url' => ['.list-article-content .entry-header h2 a','href'],
            'title' => ['.list-article-content .entry-header h2 a','text'],
            'brief' => ['#foreword','text','a',function($brief){
                $brief = str_limit(strip_tags($brief),150,'...');
                return $brief;
            }],
        ];
        $rang = 'main .article-item';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

/*    public function google(){
        $uid = 1891;
        //需要采集的目标页面
        $page = 'https://www.google.com.ph/search?sa=X&tbs=qdr:w&q=%E5%8D%9A%E5%BD%A9&tbm=nws&source=univ&tbo=u&ved=0ahUKEwif_IGe3d_VAhWKWrwKHSYBDqMQt8YBCEAoAQ&biw=1526&bih=742';
        $page_header = '';

        //采集规则
        $reg = [
            'url' => ['h3 a','href'],
            'title' => ['h3 a','text'],
            'brief' => ['.st','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '.g';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }*/

    public function winnermacau(){
        $uid = 1892;
        //需要采集的目标页面
        $page = 'http://www.winnermacau.com/news';
        $page_header = 'http://www.winnermacau.com/';

        //采集规则
        $reg = [
            'url' => ['.only-left div:first a','href'],
            'title' => ['.only-left div:first a span','text'],
            'brief' => ['.only-left','text','-div',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '.content .panel-col-first .inside .home-news';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

    public function toutiao888(){
        $uid = 1893;
        //需要采集的目标页面
        $page = 'http://www.888toutiao.com/';
        $page_header = '';

        //采集规则
        $reg = [
            'image' => ['.wrapper-grid .entry-content .image-full a img','src'],
            'url' => ['.wrapper-grid .entry-header h2 a','href'],
            'title' => ['.wrapper-grid .entry-header h2 a','text'],
            'brief' => ['.entry-content p','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '#main .content-start article';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

    public function bohecai(){
        $uid = 1894;
        //需要采集的目标页面
        $page = 'http://www.bohecai.com/xinwen/';
        $page_header = 'http://www.bohecai.com/';

        //采集规则
        $reg = [
            'image' => ['.xwt_left a img','src','',function($image) use($page_header){
                $image = $page_header.ltrim($image,'/');
                return $image;
            }],
            'url' => ['.xwt_right .xwt_right_a a','href'],
            'title' => ['.xwt_right .xwt_right_a a','text'],
            'brief' => ['.xwt_right_c','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '.content2 .left2 .xwt';
        $this->getJsData($page,$page_header,$reg,$rang,$uid);
    }

    public function caitong(){
        $uid = 1574;
        //需要采集的目标页面
        $page = 'http://caitong.sina.com.cn/';
        $page_header = '';

        //采集规则
        $reg = [
            'image' => ['.img a img','src'],
            'url' => ['h2 a','href'],
            'title' => ['h2 a','text'],
            'brief' => ['.txt .p a:first','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '.seo_data_list .news-item';
        $this->getJsData($page,$page_header,$reg,$rang,$uid);
    }

    public function pinnacle(){
        $uid = 1895;
        //需要采集的目标页面
        $page = 'https://www.pinnacle.com/zh-cn/betting-resources';
        $page_header = 'https://www.pinnacle.com/';

        //采集规则
        $reg = [
            'image' => ['.detail-info img','src','',function($image) use($page_header){
                $image = $page_header.ltrim($image,'/');
                return $image;
            }],
            'url' => ['.subtitle a','href'],
            'title' => ['.subtitle a','text'],
            'brief' => ['.introduction','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '#main .center-block ul .article-post';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

//    public function pukexinwen(){
//        //需要采集的目标页面
//        $page = 'https://www.pukexinwen.com/news-articles';
//        $page_header = '';
//
//        //采集规则
//        $reg = [
//            'image' => ['a:first .thumb img','data-original'],
//            'url' => ['a:first','href'],
//            'title' => ['a:first .info h2','text'],
//            'brief' => ['a:first .info p:last','text','',function($brief){
//                $brief = str_limit($brief,150,'...');
//                return $brief;
//            }],
//        ];
//        $rang = '.post-recent ul li';
//        $this->getData($page,$page_header,$reg,$rang);
//    }

    public function betping(){
        $uid = 1899;
        //需要采集的目标页面
        $page = 'http://www.betping.net/hy/';
        $page_header = 'http://www.betping.net/';

        //采集规则
        $reg = [
            'image' => ['.prepic a img','src','',function($image) use($page_header){
                $image = $page_header.ltrim($image,'/');
                return $image;
            }],
            'url' => ['.precon h3 a','href'],
            'title' => ['.precon h3 a','text'],
            'brief' => ['.precon p:first','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '.bp-preferential .pre-list li';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

    public function ilcaca(){
        $uid = 1900;
        //需要采集的目标页面
        $page = 'http://www.ilcaca.co/article/a/';
        $page_header = 'http://www.ilcaca.co/';

        //采集规则
        $reg = [
            'image' => ['.list-img a:last img','src','',function($image) use($page_header){
                $image = $page_header.ltrim($image,'/');
                return $image;
            }],
            'url' => ['.list-content .list-content-top h2 a','href'],
            'title' => ['.list-content .list-content-top h2 a','text'],
            'brief' => ['.list-content .list-content-top p','text','',function($brief){
                $brief = str_limit($brief,150,'...');
                return $brief;
            }],
        ];
        $rang = '#home .list';
        $rang = '#home .list';

        $this->getData($page,$page_header,$reg,$rang,$uid);
    }

    /*采集方法 end*/

    public function pushData(){
        $data_obj = Redis::hGetAll('flash_data');
        Redis::del('flash_data');
        //$title_obj = Redis::sMembers('title');
        //dd($data_obj,$title_obj);
        $data = [];
        if ($data_obj){
            foreach ($data_obj as $val){
                $data[] = unserialize($val);
            }
        }
        if ($data = array_filter($data)){
            $has = News::where(function ($query) use($data){
                foreach ($data as $k => $v){
                    $query->orWhere('title',$v['title']);
                }
            })->get();
            if ($has->all()){
                foreach ($has->all() as $k => $v){
                    foreach ($data as $i => $j){
                        if ($v['title'] == $j['title']) {
                            unset($data[$i]);
                        }
                    }
                }
            }
        }

        $newsData = [];
        $fallData = [];
        $uidArr = [];
        $number = 0;
        foreach ($data as $key => $val){
            $val['image'] = $this->factoryImg($val['image'],$val['title']);
            $newsData['image'] = $val['image'];
            $newsData['uid'] = $val['uid'];
            $newsData['cid'] = 6;
            $newsData['author'] = 1;
            $newsData['origin'] = config('query.'.$val['uid'].'.origin');
            $newsData['title'] = $val['title'];
            $url = $val['url'];
            if (intval($val['uid']) == 1892){
                $url = 'http://www.winnermacau.com/news/'.urlencode(mb_substr($url,32));
            }
            if (intval($val['uid']) == 1894 || intval($val['uid']) == 1574){
                $newsData['content'] = $this->getJsContent($url,config('query.'.$val['uid'].'.page_header'),config('query.'.$val['uid'].'.content_reg'),config('query.'.$val['uid'].'.content_rang'),config('query.'.$val['uid'].'.content_img_replace'));
            }else{
                $newsData['content'] = $this->getContent($url,config('query.'.$val['uid'].'.page_header'),config('query.'.$val['uid'].'.content_reg'),config('query.'.$val['uid'].'.content_rang'),config('query.'.$val['uid'].'.content_img_replace'));
            }
            $key_res = ToolsController::getKeyword(strip_tags(html_entity_decode($newsData['content'])));
            $newsData['key_all'] = $key_res['key_all'];
            $newsData['keywords'] = $key_res['keywords'];

            $newsData['count'] = mb_strlen(strip_tags($newsData['content']));
            $newsData['brief'] = $val['brief'];
            $newsData['status'] = 1;
            $newsData['created_at'] = date('Y-m-d H:i:s',time());
            $newsData['updated_at'] = date('Y-m-d H:i:s',time());

            if (!$newsData['content']){
                Redis::sRem('url',$val['url']);  //  sRem key member1 [member2]
                continue;
            }
            $number++;

            $fallData[$key]['title'] = $val['title'];
            $fallData[$key]['cid'] = $nid = News::insertGetId($newsData);
            $fallData[$key]['model'] = 'News';
            $fallData[$key]['uid'] = $val['uid'];
            $fallData[$key]['status'] = 1;
            $fallData[$key]['created_at'] = date('Y-m-d H:i:s',time());
            $fallData[$key]['updated_at'] = date('Y-m-d H:i:s',time());

            $url = config('base.post_boniu.url');
            $post_data['token'] = config('base.post_boniu.token');
            $post_data['title'] = $newsData['title'];
            $post_data['brief'] = $newsData['brief']?$newsData['brief']:$newsData['title'];
            $post_data['pic'] = $newsData['image'];
            $post_data['id'] = $nid;
            $post_data['addtime'] = strtotime($newsData['updated_at']);
            $post_data['content'] = $newsData['content'];
            $post_data['status'] = $newsData['status'];
            News::request_post($url, $post_data);

            $uidArr[] = $val['uid'];
        }

        $fall = new Fall();
        $res = $fall->insert($fallData);
        $uidArr = array_unique($uidArr);
        foreach($uidArr as $uid){
            $authorData['u_time'] = time();
            $authorData['publish'] = News::getAuthorNewsCount($uid);
            Author::where('uid',$uid)->update($authorData);
        }

        unlink($this->file);
        echo date('Y-m-d H:i:s')."    向数据库插入 ".$number." 条数据!  插入状态:  ". (boolval($res)?'success':'fail')." \r\n \r\n";

    }

    public function getNews($fun){
        $fun = strtolower($fun);
        if (!in_array($fun,config('query.functionList'))){
            return redirect('/');
        }
        $this->file = public_path('Lock').DIRECTORY_SEPARATOR.$fun.'.txt';
//        phpinfo();die;

        if( file_exists( $this->file ) ){
            $stat = stat($this->file);
            if( (time() - $stat['mtime']) > 180 ){
                @unlink($this->file);
                echo("文件被锁超过180秒，被强制删除!");
            }else{
                dd("脚本正在执行!");
            }
        }else{
            file_put_contents($this->file,date('Y-m-d H:i:s'). ' (开始执行脚本) ',true);
            $this->$fun();
/*            $this->wgi8();
            $this->winner365();
            $this->mm1396();
            $this->mlc365();
//            $this->imastv();
//            $this->kbet();
            $this->ultraegaming();
//            $this->google();
            $this->winnermacau();
            $this->toutiao888();
            $this->bohecai();
            $this->caitong();
            $this->pinnacle();
//            $this->pukexinwen();
            $this->betping();
            $this->ilcaca();*/
            $this->pushData();
        }
    }

}