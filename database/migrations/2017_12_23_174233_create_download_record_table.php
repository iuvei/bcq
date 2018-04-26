<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_record', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('upid')->nullable()->index()->comment('上传者id');
            $table->unsignedInteger('doid')->nullable()->index()->comment('下载者id');
            $table->unsignedInteger('did')->nullable()->index()->comment('资料id');//可能是数据报告也可能是用户资料
            $table->enum('type',['1','2'])->default('1')->comment('资料类型，1是用户资料2是数据报告');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('download_record');
    }
}