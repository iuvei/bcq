<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flash', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('title')->nullable()->comment('标题');
            $table->string('brief')->nullable()->comment('简介');
            $table->string('url')->nullable()->comment('快讯链接');
            $table->unsignedInteger('sort')->default(0)->index()->comment('排序');
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
        Schema::dropIfExists('flash');
    }
}
