<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->index()->default(0)->comment('游戏用户ID');
            $table->integer('sid')->index()->default(0)->comment('游戏商ID');
            $table->integer('status')->default(1)->comment('状态');
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
        Schema::dropIfExists('game_info');
    }
}
