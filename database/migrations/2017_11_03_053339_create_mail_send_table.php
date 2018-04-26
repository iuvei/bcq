<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailSendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_send', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('to')->nullable()->index()->comment('接受者ID');
            $table->unsignedInteger('mid')->nullable()->index()->comment('站内信ID');
            $table->tinyInteger('status')->default(1)->comment('状态：-1管理员删除，0管理员禁用，1用户未读，2用户已读，3用户删除');
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
        Schema::dropIfExists('mail_send');
    }
}
