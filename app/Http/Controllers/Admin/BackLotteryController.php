<?php
namespace App\Http\Controllers\Admin;
ini_set("max_execution_time",  "99999999");
ini_set("request_terminate_timeout",  "99999999");
//use Redis;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use App\Models\AdminModels\Lottery;

class LotteryController extends Controller
{
    protected $file;
    protected $redis;
    protected $model;
    protected $lottery_list = [
        11 => 'http://e.apiplus.net/daily.do?token=c9ed7527b5fb6e00&code=cqssc&format=json&date=',//重庆时时彩
    ];

    public function __construct()
    {
//        Redis::del('lottery_data','url');
//        dd('redis 删除成功!');
        $this->file = public_path('Lock').DIRECTORY_SEPARATOR.'lottery_lock.txt';

        $this->model = new Lottery();

    }

    public function getData($url,$flag=true){
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
        $res = curl_exec($ch);


        // 4.关闭curl会话，释放资源
        curl_close($ch);
        if ($res && $data = json_decode($res)){
            if ($data->rows > 0){
                return $data->data;
            }else{
                return [];
            }
        }else{
            return [];
        }
    }

    public function redis_set($data,$time,$code){
        $k = $code.':'.$time;
        $sdata = serialize($data);
        if ($res = Redis::get($k)){
            if ($res != $sdata){
                Redis::set($k,$sdata);
                $this->pushData($data,$time,$code);
            }
        }else{
            Redis::set($k,$sdata);
            $this->pushData($data,$time,$code);
        }
    }

    public function pushData($data,$time,$code){
        if ($data = array_filter($data)){
            $array['lottery_type'] = $code;
            $array['open_time'] = $time;
            $array['data'] = json_encode($data);
            $array['created_at'] = date('Y-m-d H:i:s');
            $array['updated_at'] = date('Y-m-d H:i:s');

            $has = $this->model->Where('open_time',$array['open_time'])->Where('lottery_type',$code)->first();
            $res = false;
            if ($has){
                if ($has->data != $array['data']){
                    $has->data = $array['data'];
                    $res = $has->save();
                }
            }else{
                $res = $this->model->insert($array);
            }
            echo $time .'==='.$res .'<br />';
        }
        unlink($this->file);
    }

    public function cqssc($time){//重庆时时彩
        $res = $this->getData($this->lottery_list[11].$time);
        sleep(10);
        $data = [];
        if ($res){
            foreach ($res as $key => $val){
                $data[$key]['expect'] = substr($val->expect,-3);
                $data[$key]['opencode'] = $val->opencode;
            }
        }
        $this->redis_set($data,$time,11);
    }

    public function lottery(){
        if( file_exists( $this->file ) ){
            $stat = stat($this->file);
            if( (time() - $stat['mtime']) > 180 ){
                @unlink($this->file);
                dd("文件被锁超过180秒，被强制删除!");
            }else{
                dd("脚本正在执行!");
            }
        }else{
            file_put_contents($this->file,date('Y-m-d H:i:s'). ' (开始执行脚本) ',true);
            $time = date('Y-m-d',time());
            $this->cqssc($time);
        }
    }

}