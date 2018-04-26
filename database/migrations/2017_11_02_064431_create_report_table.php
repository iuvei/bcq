<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('title')->nullable()->comment('标题');
            $table->text('brief')->comment('简介');
            $table->text('content')->comment('内容');
            $table->string('image')->nullable()->comment('报告封面');
            $table->string('file')->nullable()->comment('文件id');//文件地址在file表中
            $table->string('suffix')->nullable()->comment('文件后缀名');
            $table->string('keywords')->nullable()->index()->comment('关键字');
            $table->unsignedInteger('view')->default(0)->comment('浏览量');
            $table->unsignedInteger('price')->nullable()->comment('所需种子');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('状态：-1删除，0审核，1启用');
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
        Schema::dropIfExists('report');
    }
}
