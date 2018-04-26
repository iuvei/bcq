<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   //企业库
        Schema::create('cash', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('title')->nullable()->comment('企业名称');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedInteger('access')->nullable(0)->comment('接入平台');
            $table->unsignedInteger('games')->nullable(0)->comment('主营游戏');
            $table->unsignedInteger('region')->nullable(0)->comment('地区');
            $table->unsignedInteger('view')->default(0)->comment('浏览次数');
            $table->string('addip')->nullable()->comment('注册ip');
            $table->string('url1')->nullable()->comment('现金网网址1');
            $table->string('url2')->nullable()->comment('现金网网址2');
            $table->string('url3')->nullable()->comment('现金网网址3');
            $table->string('url4')->nullable()->comment('现金网网址4');
            $table->tinyInteger('mark')->nullable()->default(0)->comment('平均分');
            $table->tinyInteger('mark1')->nullable()->default(0)->comment('评分1');
            $table->tinyInteger('mark2')->nullable()->default(0)->comment('评分2');
            $table->tinyInteger('mark3')->nullable()->default(0)->comment('评分3');
            $table->tinyInteger('mark4')->nullable()->default(0)->comment('评分4');
            $table->text('content')->comment('现金网简介');
            $table->string('logo')->nullable()->comment('json');
            $table->tinyInteger('status')->default(0)->comment('状态：-1删除，0禁用，1启用');
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
        Schema::dropIfExists('cash');
    }
}
