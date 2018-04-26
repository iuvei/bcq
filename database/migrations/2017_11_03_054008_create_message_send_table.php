<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_send', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('from')->nullable()->index()->comment('发送者ID');
            $table->unsignedInteger('to')->nullable()->index()->comment('接受者ID');
            $table->text('content')->comment('内容');
            $table->tinyInteger('status')->default(1)->comment('状态：-1发送者删除，0发送者禁用，1接受者未读，2接受者已读，3接受者删除');
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
        Schema::dropIfExists('message_send');
    }
}
