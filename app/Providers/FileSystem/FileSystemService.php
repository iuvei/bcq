<?php

namespace App\Providers\FileSystem;
use Config;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use App\Models\File as File;
class FileSystemService implements FileSystemContract {

    private $appObj;//app操作的是storage下的app目录，这个目录一般是不对外展示的，一般为资料等

    private $appPath;

    private $publicObj;//public操作的是storage下的public目录，这个目录一般是对外展示的，一般为图片

    private $publicPath;

    private $fileObj;

    private $publicSoftPath = '/storage/';//public目录下的软连接

    public function __construct()
    {
        $this->appObj = Storage::disk('local');

        $this->publicObj = Storage::disk('public');

        $this->appPath = storage_path() . '/app/';

        $this->publicPath = storage_path() . '/app/public/';

        $this->fileObj = new File();
    }

    public function uploadPublicFile($file,$dir){//上传公共资源文件

        if (!$file->isValid()){
            return ['code'=>0,'msg'=>'文件非法'];
        }
        if(!in_array(strtolower($file->getClientOriginalExtension()),['jpeg','jpg','png','gif','tiff','raw','bmp'])){
            return ['code'=>0,'msg'=>'文件格式有误, support( jpeg jpg png gif tiff raw bmp ) '];
        }
        $path = $this->putFile($file,$this->publicObj,$dir);

        $show_path = $this->publicSoftPath.$path;

        return ['code'=>1,'path'=>$show_path];
    }

    public function uploadPublicFileBase64($data,$dir){//上传公共资源文件
    
        $data = explode(',',$data);

        $data = end($data);

        $date = date('Ymd');
        
        $dir = $dir.'/'.$date;

        if (!$this->publicObj->exists($dir)){

            $this->publicObj->makeDirectory($dir);
        
        }
        
        $filename = md5(uniqid(mt_rand(), true)).'.png';

        $path = $dir.'/'.$filename;

        $real_path = $this->publicPath.$path;
        
        file_put_contents($real_path, base64_decode($data));

        $show_path = $this->publicSoftPath.$path;

        return ['code'=>1,'path'=>$show_path];
    }    

    public function uploadDataFile($file,$dir){//上传资料文件

        if (!$file->isValid()){
            return ['code'=>0,'msg'=>'文件非法'];
        }
        if(!in_array(strtolower($file->getClientOriginalExtension()),['pdf','rar','zip'])){
            return ['code'=>0,'msg'=>'文件格式有误,support( pdf rar zip )'];
        }

        $path = $this->putFile($file,$this->appObj,$dir);

        $file_obj = $this->fileObj->addFile($path);

        return ['code'=>1,'file_id'=>$file_obj->id];
    }

    public function putFile($file,$disk_obj,$dir){

        $date = date('Ymd');

        $dir = $dir.'/'.$date;

        if (!$disk_obj->exists($dir)){
            $disk_obj->makeDirectory($dir);
        }

        $path = $disk_obj->putFile($dir, $file);

        return $path;
    }

    public function downloadFile($file_id,$record=false){//下载文件,返回文件路径

        $path = $this->fileObj->getPath($file_id);

        if (!$path){
            return ['code'=>0,'msg'=>'file not exits'];
        }

        $pathToFile = $this->appPath .$path;

        $exists = file_exists($pathToFile);

        if (!$exists){

            return ['code'=>0,'msg'=>'file not exits'];

        };

        if($record){

            $this->fileObj->downloadRecord($file_id);
            
        }
        return ['code'=>1,'path'=>$pathToFile];
    }

    public function fileExists($file_id,$type = 'app'){

        $path = $this->fileObj->getPath($file_id);

        if (!$path){
            return ['code'=>0,'msg'=>'文件资源路径有误'];
        }
        if ($type == 'app'){
            $exists = file_exists($this->appPath .$path);
        }
        if ($type == 'public'){
            $exists = file_exists($this->publicPath .$path);
        }
        if (!$exists){
            return ['code'=>0,'msg'=>'文件资源不存在'];
        }
        return ['code'=>1,'msg'=>'文件资源正常'];
    }
}