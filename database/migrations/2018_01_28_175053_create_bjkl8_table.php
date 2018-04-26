<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBjkl8Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_bjkl8', function (Blueprint $table) {
            $table->increments('id');
            $table->string('issue',50)->default('')->comment('期号');
            $table->string('code',200)->default('')->comment('开奖号');
            $table->unsignedInteger('open_time')->default(0)->comment('开奖时间');
            $table->string('image',100)->default('')->comment('开奖截图');
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
        Schema::dropIfExists('bjkl8');
    }
}
