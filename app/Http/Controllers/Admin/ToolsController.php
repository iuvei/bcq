<?php
namespace App\Http\Controllers\Admin;
use App\Models\AdminModels\Key;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Redis;
use Illuminate\Support\Facades\Redis;
use FileSystem;

class ToolsController extends Controller
{
    protected $imgExt = ['jpeg','jpg','png','gif','tiff','raw','bmp'];
    protected $fileExt = ['doc','docx','pdf','xls','xlsx','ppt','txt','rar','zip'];

    public function file_upload(Request $request){
        if(in_array(strtolower($request->file('file')->getClientOriginalExtension()),$this->imgExt)){
            $file = FileSystem::uploadPublicFile($request->file('file'),'image');
        }elseif (in_array(strtolower($request->file('file')->getClientOriginalExtension()),$this->fileExt)){
            $file = FileSystem::uploadDataFile($request->file('file'),'file');
        }else{
            $file = ['code'=>0,'msg'=>'上传文件不合法'];
        }
        return json_encode($file);
    }

    static function datastatus($status,$idArray,$model){
        $return_data['code'] = '-1';
        $return_data['msg'] = '系统错误，请稍候再试！';
        if(!empty($idArray)){
            switch ($status){
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
            $res = $model->whereIn('id', $idArray)->update($data);
            if ($res !== false) {
                if ($model->getTable() == 'news'){
//                    $url = 'http://www.boniu365.co/index.php?r=news%2Fupdate-status';
//                    $post_data['token'] = 'bn_iTeR19Y6';
//                    $post_data['id'] = implode(',',$idArray);
//                    $post_data['status'] = $data['status'];
//                    News::request_post($url, $post_data);
                }
                $return_data['code'] = '1';
                $return_data['msg'] = '成功';
            }else{
                $return_data['code'] = '0';
                $return_data['msg'] = '系统错误，请稍候再试！';
            }
        }
        return json_encode($return_data);
    }

    static function getKeyword($_str,$up_flag = true){
        $config = array('max_len'=>5, 'r_name'=>0, 'mix_len'=>2, 'lna_len'=>1, 'add_syn'=>0,
            'clr_stw'=>1, 'keep_urec'=>0, 'spx_out'=>0, 'en_sseg'=> 0, 'st_minl'=>0, 'kpuncs'=>'@%.#&+', 'mode'=>2);
        $res = friso_split($_str, $config, FRISO_RET_WORD);

        $return['key_all'] = '';
        $return['keywords'] = '';
        if (!$res){
            return $return;
            die();
        }
        $res = array_column($res, 'word');

        foreach ($res as $v){
            if(Redis::zScore('keyword',$v)){
                Redis::zIncrBy('keyword',1,$v);
            }else{
                Redis::zAdd('keyword',1,$v);
            }
        }

        if (intval(Redis::get('disable_new_keyword_flag')) || Redis::zCard('disable_keyword') == 0){
            Redis::set('disable_new_keyword_flag',0);
            Redis::del('disable_keyword');
            $disable_keyword = Key::where('status',0)->select('keywords')->get();
            foreach ($disable_keyword as $i){
                Redis::zAdd('disable_keyword',1,$i->keywords);
            }
        }

        $disable = Redis::zRangeByScore('disable_keyword', -INF, INF, array('withscores' => TRUE));
        foreach ($disable as $key => $val){
            Redis::zRem('keyword',$key);
        }

        $keyword = Redis::zRangeByScore('keyword', -INF, INF, array('withscores' => TRUE));
        arsort($keyword);
        Redis::del('keyword');

        foreach ($keyword as $key => $val){
            if(mb_strlen($key) == 1 || is_numeric($key)){
                unset($keyword[$key]);
            }
        }

        foreach ($keyword as $k => $v){
            if ($up_flag){
                $inc_res = Key::where('keywords',$k)->increment('num',$v);
                if (!$inc_res){
                    Key::Create(
                        ['keywords' => $k,'num' => $v]
                    );
                }
            }
            $return['key_all'] .= '<a onclick="keyword(\''.$k.'\')">'.$k."</a>($v),";
        }
        $return['key_all'] = trim($return['key_all'],',');
        $return['keywords'] = implode(',',array_slice(array_keys($keyword),0,10));

        return $return;
    }

    static function getKey($_str){
        dd(Redis::del('keynum'));

        $config = array('max_len'=>5, 'r_name'=>0, 'mix_len'=>2, 'lna_len'=>1, 'add_syn'=>0,
            'clr_stw'=>1, 'keep_urec'=>0, 'spx_out'=>0, 'en_sseg'=> 0, 'st_minl'=>0, 'kpuncs'=>'@%.#&+', 'mode'=>2);
        $res = friso_split($_str, $config, FRISO_RET_WORD);

        $return['msg'] = 'no';
        if (!$res){
            return $return;
            die();
        }
        $res = array_column($res, 'word');

        foreach ($res as $v){
            if(Redis::zScore('keynum',$v)){
                Redis::zIncrBy('keynum',1,$v);
            }else{
                Redis::zAdd('keynum',1,$v);
            }
        }

//        $keyword = Redis::zRangeByScore('keynum', -INF, INF, array('withscores' => TRUE));
//        arsort($keyword);
//
//        foreach ($keyword as $key => $val){
//            if(mb_strlen($key) == 1 || is_numeric($key)){
//                unset($keyword[$key]);
//            }
//        }
//        foreach ($keyword as $k => $v){
//
//        }
//
//        $return['msg'] = 'ok';
//        return $return;
    }

}