<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedInteger('starttime')->nullable()->comment('开始时间');
            $table->unsignedInteger('endtime')->nullable()->comment('结束时间');
            $table->string('title')->nullable()->comment('标题');
            $table->unsignedInteger('pid')->nullable()->index()->comment('广告位页面id');
            $table->string('url')->default('javascript:;')->comment('广告链接');
            $table->string('image')->nullable()->comment('封面图片');
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
        Schema::dropIfExists('banner');
    }
}
