<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('发布作者');
            $table->unsignedInteger('cid')->nullable()->index()->comment('所属分类');
            $table->unsignedInteger('ucid')->nullable()->index()->comment('所属自定义分类');//用户自定义分类
            $table->unsignedInteger('count')->default(0)->comment('文章字数');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedInteger('view')->default(0)->comment('浏览量');
            $table->unsignedInteger('top')->default(0)->comment('点赞');
            $table->string('title')->nullable()->comment('标题');
            $table->string('origin')->nullable()->comment('来源/作者');
            $table->unsignedTinyInteger('author')->default(0)->comment('来源于用户 1：是，0：否');
            $table->text('image')->nullable()->comment('封面图片');
            $table->string('keywords')->nullable()->index()->comment('关键字');
            $table->string('brief')->nullable()->comment('简介');
            $table->text('content')->comment('内容');
            $table->tinyInteger('status')->default(-2)->index()->comment('状态：-3保存文章未发表，-2退回通知，-1删除，0审核，1启用');
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
        Schema::dropIfExists('news');
    }
}
