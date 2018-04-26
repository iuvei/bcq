<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('上传用户ID');
            $table->string('title')->nullable()->comment('标题');
            $table->string('brief')->nullable()->comment('简介');
            $table->string('file')->nullable()->comment('文件地址id');//文件地址在file表中
            $table->string('keywords')->nullable()->comment('关键字');
            $table->unsignedInteger('type')->nullable()->index()->comment('资料类型');
            $table->string('suffix')->nullable()->comment('资料后缀名');
            $table->unsignedInteger('view')->default(0)->comment('浏览量');
            $table->unsignedInteger('price')->nullable()->comment('所需种子');
            $table->unsignedInteger('sort')->default(0)->index()->comment('排序');
            $table->tinyInteger('status')->default(0)->comment('状态：-1删除，0审核，1启用');
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
        Schema::dropIfExists('data');
    }
}
