<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('ucid')->nullable()->index()->comment('网址分类id');
            $table->string('title')->nullable()->comment('标题');
            $table->string('url')->nullable()->comment('网址链接');
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
        Schema::dropIfExists('url');
    }
}
