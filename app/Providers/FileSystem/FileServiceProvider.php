<?php

namespace App\Providers\FileSystem;
use Illuminate\Support\ServiceProvider;
use App\Providers\FileSystem\FileSystemService as FileSystemService;
class FileServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    protected $defer = true;

    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //文件系统服务（文件上传 文件下载等操作）
        $this->app->bind('App\Providers\FileSystem\FileSystemService',function ($app){
            $file = new FileSystemService();
            return $file;
        });
    }

    public function provides()
    {
        return ['App\Providers\FileSystem\FileSystemService'];
    }
}