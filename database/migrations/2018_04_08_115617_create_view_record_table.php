<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_record', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid')->default()->index()->comment('用户id');
            $table->integer('view')->default(0)->comment('当天浏览量');
            $table->string('date')->index()->default('')->comment('当日日期');            
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
        Schema::dropIfExists('view_record');
    }
}
