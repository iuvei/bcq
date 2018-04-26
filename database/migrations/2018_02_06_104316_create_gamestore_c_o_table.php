<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamestoreCOTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamestore_c_o', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('gid')->default(0)->comment('游戏商ID');
            $table->unsignedInteger('cid')->default(0)->comment('游戏分类ID');
            $table->unsignedInteger('sort')->default(0)->comment('对应分类游戏排序');
            $table->tinyInteger('status')->default(1)->comment('状态：-1删除，0禁用，1启用');
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
        Schema::dropIfExists('gamestore_c_o');
    }
}
