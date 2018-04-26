<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('title')->nullable()->comment('标题');
            $table->string('name')->nullable()->comment('模块变量名');
            $table->unsignedInteger('sort')->default(0)->comment('排名');
            $table->tinyInteger('status')->default(1)->comment('状态：0关闭，1启用');
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
        Schema::dropIfExists('module');
    }
}
