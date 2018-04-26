<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_record', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('uid')->index()->nullable()->comment('获得积分的用户');
            $table->Integer('type')->index()->nullable()->comment('获得或消耗积分的渠道');//1 用户资料 2 数据报告 3 互动问答
            $table->string('tid')->index()->nullable()->comment('类型主键id');            
            $table->Integer('price')->default(0)->comment('获得积分数量');
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
        Schema::dropIfExists('price_record');
    }
}
