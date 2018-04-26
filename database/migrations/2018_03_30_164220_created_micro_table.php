<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedMicroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0)->index()->comment('用户id');
            $table->enum('utype',[0,1])->default(0)->comment('用户类型 0普通用户 1游戏用户');
            $table->text('content')->comment('动态内容');
            $table->text('image')->comment('动态图片');            
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedInteger('view')->default(0)->comment('浏览量');
            $table->unsignedInteger('top')->default(0)->comment('点赞');
            $table->unsignedInteger('f_view')->default(0)->comment('fate浏览量'); 
            $table->unsignedInteger('unread')->default(0)->comment('有无未读评论');
            $table->integer('status')->default(0)->index()->comment('状态');
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
        Schema::dropIfExists('micro');
    }
}
