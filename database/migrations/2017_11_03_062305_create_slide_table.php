<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('title')->nullable()->comment('标题');
            $table->unsignedInteger('slide_id')->nullable()->index()->comment('信息id');
            $table->text('image')->nullable()->comment('封面图片');
            $table->string('slide_type')->nullable()->comment('信息类型');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->string('url')->nullable()->comment('信息链接');
            $table->unsignedTinyInteger('type')->default(0)->comment('幻灯类型 1：轮播，2：卡片');
            $table->tinyInteger('status')->default(0)->comment('状态：-1删除，0审核/禁用，1启用');

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
        Schema::dropIfExists('slide');
    }
}
