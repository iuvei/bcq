<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
if (! function_exists('put_session')) {
    /**
     * 获取或设置登录用户 Session
     * @param Member|null $member
     * @return mixed|Member
     */
    function put_session($key,$value,$isExpired = false)
    {
        if ($isExpired){
            Session::forget($key);
        }else{
            Session::put($key,$value);
        }
    }
}

if (!function_exists('get_session')){
    function get_session($key){
        return Session::get($key);
    }
}

if (!function_exists('has_session')){
    function has_session($key){
        return Session::has($key);
    }
}

if (!function_exists('get_cache')){
    function get_cache($key){
        return Cache::get($key);
    }
}

if (!function_exists('camelize')) {
    function camelize($uncamelized_words, $separator = '_')
    {
        $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
    }
}
if (!function_exists('uncamelize')) {
    function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}

if (!function_exists('get_user_info')){

    function get_user_info(){

        $user_id = get_session(config('etc.account.login_key'));

        if (!$user_id){

            return ['code'=>0,'msg'=>'请先登录账号'];

        }

        $user = User::getUserInfo($user_id);

        if (!$user){
            return ['code'=>0,'msg'=>'用户资料有误，请联系管理员'];
        }

        return ['code'=>1,'user'=>$user];
    }
}

if (!function_exists('get_model_obj')){

    function get_model_obj($model){

        $model_name_space = 'App\\Models\\';

        $class = $model_name_space . $model;

        $news_obj = new $class();

        return $news_obj;
    }
}

if (!function_exists('page_helper')){//这个是针对于加载更多形式的分页控件的
    function page_helper($page,$render_limit,$page_limit){//我们默认render时候 page 是 0
        if (empty($page)){
            $limit = $render_limit;
            $skip = 0;
        }else{
            $limit = $page_limit;
            $skip = $page_limit*($page-1) + $render_limit;
        }

        return ['skip'=>$skip,'limit'=>$limit];
    }
}

if (!function_exists('convert_type')) {//用二进制进行筛选
    function convert_type($val,$config){//$val 是要进行筛选的  $conig是我们配置的种类名及其对应的值
        $cats = [];
        foreach ($config as $key => $value) {
            if($value['val']&$val){
                $cats[$key]['name'] = $value['name'];
                $cats[$key]['val'] = $value['val'];   
            }
        }
        return $cats;
    }
}


if (!function_exists('curl_post')) {

    function curl_post($url,$data,$headers=[]){

        $ch = curl_init(); 

        if (!empty($headers)) {
                
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_HEADER, 0); 

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,$url);  

        curl_setopt($ch, CURLOPT_POST,1);  

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  

        $result = curl_exec($ch); 

        if (!$result) {
        
            return curl_error($ch);
        } 

        curl_close($ch);

        return $result;        
    }    
}

if (!function_exists('curl_get')) {

    function curl_get($url){

        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  

        curl_setopt($ch, CURLOPT_URL,$url);  

        $result = curl_exec($ch);  

        curl_close($ch);

        return $result;        
    }    
}

if (!function_exists('name_filter')) {//防止用户名出现电话
    
    function name_filter($name){

        if (!empty($name)) {
            
            $black=array(" ","　","\t","\n","\r");
            
            $replace=array("","","","","");

            $pure = str_replace($black,$replace,$name);
            
            if (is_numeric($pure)&&strlen($pure)>7) {
            
                $str_array = str_split($pure);
            
                $len = count($str_array);
            
                $rename = '';
            
                foreach ($str_array as $key => $value) {
                    
                    if ($key>2&&$key<($len-3)) {
            
                        $rename = $rename.'*';
            
                    }else{
            
                        $rename = $rename.$value;
                    }
                }
                return $rename;
            }

            return $name;
        }
    }
}


if (!function_exists('view_rand')) {

    function view_rand($f_view,$time,$conf){
    
        if ($f_view<70&&$time>2) {
    
            $view = $conf['inhour'];
    
            return $view;
    
        }else{

            $view = $conf['rand'];
    
            return $view;
    
        }
    }
}