<?php
namespace App\Providers\FileSystem;

interface FileSystemContract{

    public function uploadDataFile($file,$dir);//上传资料文件

    public function uploadPublicFile($file,$dir);//上传公共资源文件

    public function downloadFile($path);//下载文件
}