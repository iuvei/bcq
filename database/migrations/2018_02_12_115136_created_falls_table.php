<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedFallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('falls', function (Blueprint $table) {//首页信息流
            $table->increments('id');
            $table->unsignedInteger('cid')->index()->default(0)->comment('各类型的主键id');
            $table->string('model')->default('')->comment('该类型的模型');
            $table->unsignedInteger('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('falls');
    }
}
