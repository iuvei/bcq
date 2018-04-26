<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('user_author', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('用户id');
            $table->string('blog')->nullable()->comment('作者博客地址');
            $table->tinyInteger('recommend')->default(0)->comment('是否推荐作者');//0不是推荐作者 1是推荐作者
            $table->unsignedInteger('publish')->default(0)->comment('发表量');
            $table->unsignedInteger('u_time')->default(0)->comment('更新文章时间');
            $table->unsignedTinyInteger('is_admin')->default(0)->comment('关联管理员 1：是，0：否');
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
        Schema::dropIfExists('user_author');
    }
}
