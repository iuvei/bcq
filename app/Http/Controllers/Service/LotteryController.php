<?php
namespace App\Http\Controllers\Service;
ini_set("max_execution_time",  "99999999");
ini_set("request_terminate_timeout",  "99999999");

//use Redis;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Service\ToolsController;
use App\Models\AdminModels\LotteryNotice;
use App\Models\AdminModels\Micro;
use App\Models\AdminModels\Fall;
use Illuminate\Contracts\Encryption\DecryptException;

class LotteryController extends Controller
{
    protected $method = 'AES-256-CBC';
    //protected $key = 'dHIVxVHDrASGcpwDNC0KNgHFPneqRUjK';
    protected $key = '4f378a04ecd7325107d9716764672f1a';
    protected $lockFile;
    protected $SetLotteryLog;
    protected $LotteryNotice;
    protected $redis;
    protected $disk_obj;
    protected $model_path = "App\\Models\\LotteryModels\\";
    protected $url = 'https://source.ecsvc.info/lottery/latest';

    public function __construct()
    {
//        Redis::flushall();
//        dd('redis 删除成功!');
        $this->disk_obj = Storage::disk('public');
        $this->lockFile = public_path('Lock').DIRECTORY_SEPARATOR.'lottery_lock.txt';
        $this->SetLotteryLog = public_path('Lock').DIRECTORY_SEPARATOR.'set_lottery_log.txt';
        $this->LotteryNotice = public_path('Lock').DIRECTORY_SEPARATOR.'lottery_notice.txt';

    }

    public function setUrl($lottery,$issue)
    {
        return $this->url.$lottery.'/issue/'.$issue;

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

    public function getData($url){
        // 1.初始化一个curl会话资源
        $ch = curl_init();
        // 2.设置curl会话的选项
        $header = array();
        $header[] =  config('lottery.key_name').':'.config('lottery.key_password');
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);        // 设置HTTP请求头
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_URL, $url);    // 设置需要请求的URL地址，也可以在 curl_init()函数中设置
        // 3.执行curl会话
        $res = curl_exec($ch);

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
                $image_name = md5($km).'.png';
                if(file_exists(public_path().DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$dir.$image_name) || $this->disk_obj->put($dir.$image_name, $image_data)){
                    $image = DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$dir.$image_name;
                }
            } catch (\GuzzleHttp\RequestException $e) {
            }
        }
        return $image;
    }

    public function redis_set($data){
        $lottery = strtolower($data->lottery);
        $issue = $data->issue;
        $k = $lottery.':'.$issue;
        $km = $k.'-image';
        $data->image = $this->factoryImg($data->image,$km);
        $sdata = serialize($data);
        if ($res = Redis::get($k)){
            if ($res != $sdata){
                Redis::set($k,$sdata);
                $this->pushData($data,$lottery);
            }
        }else{
            Redis::set($k,$sdata);
            $this->pushData($data,$lottery);
        }
    }

    public function pushData($data,$lottery){
        $model_name = $this->model_path.config('lottery.lottery_list.'.$lottery.'.model');
        $model = new $model_name;
        if ($res = $model->where('issue',$data->issue)->first()){
            if ($res->code != $data->code || $res->image != $data->image){
                $res->code = $data->code;
                $res->image = $data->image;
                $res->save();
            }
        }else{
            $insert['issue'] = $data->issue;
            $insert['code'] = $data->code;
            $insert['open_time'] = strtotime($data->end_time);
            $insert['image'] = $data->image;
            $insert['created_at'] = date('Y-m-d H:i:s',time());
            $insert['updated_at'] = date('Y-m-d H:i:s',time());
            $res = $model->insert($insert);
        }
    }

    public function factory($res,$flag=true){

        $obj = json_decode($res);

        if ($obj->message === 'Success'){
            if ($flag){
                foreach ($obj->data as $val){
                    $this->redis_set($val);
                }
            }else{
                $this->redis_set($obj->data);
            }
        }else{
            return false;
        }

    }

    public function lottery(){
        if( file_exists( $this->lockFile ) ){
            $stat = stat($this->lockFile);
            if( (time() - $stat['mtime']) > 180 ){
                @unlink($this->lockFile);
                echo "文件被锁超过180秒，被强制删除!";
            }else{
                echo "脚本正在执行!";
            }
        }else{
            file_put_contents($this->lockFile,date('Y-m-d H:i:s'). ' (开始执行脚本) ',true);
            $res = $this->getData($this->url);
            dd(json_decode($res));

//            dd(json_decode($res));
            $this->factory($res,true);
            @unlink($this->lockFile);

        }
    }

    public function issue($lottery,$issue){
        $url = "https://source.ecsvc.info/lottery/$lottery/issue/$issue";
        $res = $this->getData($url);
        $res = json_decode($res);
        if ($res->message === 'Success'){
            $res->data->lottery = $lottery;
            $res = json_encode($res);
            $this->factory($res,false);
            $model_name = $this->model_path.config('lottery.lottery_list.'.$lottery.'.model');
            $model = new $model_name;
            $res = $model->where('issue',$issue)->select('image')->first();
            if ($res){
                $image = $res->image;
            }else{
                $image = '';

            }
            return $image;
        }else{
            return '';
        }
    }

    public function issue_each(){
        $last_res = json_decode($this->getData($this->url));
        $last_list = $last_res->data;
//        dd($last_list);
        //$lottery_list = config('lottery.lottery_list');
        $url_list = array();
        foreach ($last_list as $k => $v){
            $lottery = $v->lottery;
            $res_issue = $v->issue;
            $j = 120;
            for($i=0;$i<$j;$i++) {
                if ($lottery == 'jx11y' || $lottery == 'ssl'){
                    $issue_arr = explode('-',$res_issue);
                    if (!(intval($issue_arr[1] - $i) <= 0)){
                        $issue = $issue_arr[0].'-'.(intval($issue_arr[1]) - $i);
                        //dd($issue);
                    }else{
                        break;
                    }
                }else if($lottery == 'cqssc'){
                    $start = substr($res_issue,0,6);
                    $end = substr($res_issue,-3);
                    if ((intval($end)-$i) <= 0){
                        $res_issue = (intval($start) - 1).'120';
                        $issue = $res_issue;
                        $i = 0;
                    }else{
                        $issue = intval($res_issue) - $i;
                    }
                }else if($lottery == 'hljssc'){
                    $issue = intval($res_issue) - $i;
                    $issue = '0'.$issue;
                }else{
                    $issue = intval($res_issue) - $i;
                }

                $url = "https://source.ecsvc.info/lottery/$lottery/issue/$issue";
                $url_list[] = $url;
                $res = json_decode($this->getData($url));
                if ($res->message === 'Success'){
                    $data['issue'] = $res->data->issue;
                    $data['code'] = $res->data->code;
                    $data['open_time'] = strtotime($res->data->end_time);

                    $model_name = $this->model_path.config('lottery.lottery_list.'.$lottery.'.model');
                    $model = new $model_name;
                    $model->updateOrCreate(
                        ['issue' => $data['issue']],
                        $data
                    );
                }
            }
        }
        dd($url_list);
    }

    public function setLottery(Request $request){
        $res = $request->getContent();

        $tools = new ToolsController($this->method, $this->key);
        try{
            $str = $tools->decrypt($res);
        }catch (DecryptException $e) {
            return $e->getMessage();
        }

        $data = json_decode($str);
        if ($data->level == 'PRODUCT'){
            $lottery = strtolower($data->data->lottery);
            $in_data['issue'] = $data->data->issue;
            $in_data['code'] = $data->data->code;
            $in_data['open_time'] = strtotime($data->data->end_time);
            $in_data['next_issue'] = $data->data->next_issue;
            $in_data['next_end_time'] = strtotime($data->data->next_end_time);
            $model_name = $this->model_path.config('lottery.lottery_list.'.$lottery.'.model');
            $model_name::updateOrCreate(
                ['issue' => $in_data['issue']],
                $in_data
            );
        }

        file_put_contents($this->SetLotteryLog,date('Y-m-d H:i:s') . '——' . $str . "\r\n", FILE_APPEND);
        return 'ok';
    }

    public function LotteryNotice(Request $request){
        $res = $request->getContent();

        $tools = new ToolsController($this->method, $this->key);

        try{
            $str = $tools->decrypt($res);
        }catch (DecryptException $e) {
            return $e->getMessage();
        }

        $data = json_decode($str);

        if ($res = LotteryNotice::where('message_id',$data->data->message_id)->first()){
            if (intval($data->data->message_status)){
                $micro_data['uid'] = 1561;
                $micro_data['utype'] = '0';
                $micro_data['status'] = 1;
                $micro_data['created_at'] = $res->created_at;
                $micro_data['content'] = $data->data->body;
                $res->title = $data->data->title;
                $res->body = $data->data->body;
                $res->sender = $data->data->sender;
                if (intval($data->data->type)){
                    $res->path = $data->data->path;
                    $res->caption = $data->data->caption;
                    $micro_data['image'] = json_encode($data->data->path);
                }else{
                    $micro_data['image'] = json_encode(array());
                }

                $fallData['title'] = $micro_data['content'];
                $fallData['cid'] = $res->mid;
                $fallData['model'] = 'Micro';
                $fallData['uid'] = $micro_data['uid'];
                $fallData['status'] = 1;
                $fallData['created_at'] = $res->created_at;

                Micro::updateOrCreate(
                    ['id' => $res->mid,'uid' => $micro_data['uid']],
                    $micro_data
                );
                Fall::updateOrCreate(
                    ['cid' => $res->mid,'model' => 'Micro'],
                    $fallData
                );

                $res->save();
            }
        }else{
            $micro_data['uid'] = 1561;
            $micro_data['utype'] = '0';
            $micro_data['status'] = 1;
            $micro_data['content'] = $data->data->body;
            $notice_data['message_id'] = $data->data->message_id;
            $notice_data['channel_name'] = $data->data->channel_name;
            $notice_data['title'] = $data->data->title;
            $notice_data['type'] = $data->data->type;
            $notice_data['message_status'] = $data->data->message_status;
            $notice_data['body'] = $data->data->body;
            $notice_data['sender'] = $data->data->sender;
            if (intval($data->data->type)){
                $micro_data['image'] = json_encode($data->data->path);
                $notice_data['path'] = $data->data->path;
                $notice_data['caption'] = $data->data->caption;
            }else{
                $micro_data['image'] = json_encode(array());
            }
            $micro_data['created_at'] = date('Y-m-d H:i:s',time());
            $micro_data['updated_at'] = date('Y-m-d H:i:s',time());
            $notice_data['mid'] = $mid = Micro::insertGetId($micro_data);

            $fallData['title'] = $micro_data['content'];
            $fallData['cid'] = $mid;
            $fallData['model'] = 'Micro';
            $fallData['uid'] = $micro_data['uid'];
            $fallData['status'] = 1;
            $fallData['created_at'] = $micro_data['created_at'];
            Fall::updateOrCreate(
                ['cid' => $mid,'model' => 'Micro'],
                $fallData
            );

            LotteryNotice::create($notice_data);
        }
        return 'ok';
    }

}