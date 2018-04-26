<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('show', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedTinyInteger('famous')->nullable()->comment('名展 0：否 ；1：是');
            $table->unsignedInteger('starttime')->nullable()->comment('开始时间');
            $table->unsignedInteger('endtime')->nullable()->comment('结束时间');
            $table->unsignedInteger('view')->default(0)->comment('浏览次数');
            $table->string('title')->nullable()->comment('标题');
            $table->string('short')->nullable()->comment('简称');
            $table->string('sponsor')->nullable()->comment('主办方');
            $table->string('address')->nullable()->comment('举办地');
            $table->string('image')->nullable()->comment('封面图片');
            $table->string('url')->nullable()->comment('官方网址');
            $table->text('content')->comment('展会简介');
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
        Schema::dropIfExists('show');
    }
}
