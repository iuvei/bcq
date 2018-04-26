<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id')->commnet('等级');
            $table->string('title')->nullable()->comment('等级名称');
            $table->integer('min')->nullable()->comment('该等级最小分值');
            $table->integer('max')->nullable()->comment('该等级最大分值');
            $table->tinyInteger('status')->default(1)->comment('状态：-1删除，0审核/禁用，1启用');
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
        Schema::dropIfExists('level');
    }
}
