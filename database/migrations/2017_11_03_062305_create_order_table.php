<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('订单拥有者');
            $table->string('pay_type')->nullable()->comment('系统配置：消费商品类型');
            $table->unsignedTinyInteger('type')->nullable()->comment('消费类型：1：扣除，2：增加');
            $table->unsignedInteger('pay_id')->nullable()->index()->comment('消费商品id');
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
        Schema::dropIfExists('order');
    }
}
