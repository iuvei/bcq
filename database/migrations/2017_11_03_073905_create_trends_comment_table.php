<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrendsCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trends_comment', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('tid')->nullable()->index()->comment('产品id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('用户id');
            $table->unsignedInteger('tcid')->default(0)->index()->comment('关联评论id');
            $table->unsignedInteger('top')->default(0)->comment('点赞');
            $table->unsignedInteger('complaint')->default(0)->comment('投诉');
            $table->text('content')->comment('内容');
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
        Schema::dropIfExists('trends_comment');
    }
}
