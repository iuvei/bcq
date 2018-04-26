<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedLotteryNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_notice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')->index()->comment('信息id');
            $table->integer('mid')->comment('微动态id');
            $table->string('channel_name')->nullable()->comment('channel名字');
            $table->string('title')->nullable()->comment('公告标题');
            $table->string('body')->nullable()->comment('公告内容');
            $table->string('sender')->nullable()->comment('公告发送主题');
            $table->unsignedTinyInteger('type')->default(0)->comment('信息类别：0文本 1图片');
            $table->unsignedTinyInteger('message_status')->default(0)->comment('信息状态：0新信息 1编辑信息');
            $table->string('path')->nullable()->comment('图片地址');
            $table->string('caption')->nullable()->comment('图片文字说明');
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
        Schema::dropIfExists('lottery_notice');
    }
}
