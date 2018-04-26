<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_position', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id')->comment('位置id');
            $table->unsignedInteger('pid')->index()->comment('广告位页面id');
            $table->unsignedInteger('lid')->index()->comment('广告位页面位置id');
            $table->string('title')->nullable()->comment('标题');
            $table->tinyInteger('status')->default(1)->comment('状态:0停用，1启用');
            $table->timestamps();
            $table->unique(['pid', 'lid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_position');
    }
}
