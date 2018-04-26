<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamestoreCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamestore_category', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('gname')->nullable()->comment('游戏商分类名');
            $table->string('image')->nullable()->comment('游戏商分类封面');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('gamestore_category');
    }
}
