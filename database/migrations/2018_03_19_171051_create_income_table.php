<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid')->index();
            $table->unsignedInteger('price')->default(0);
            $table->string('phone')->index()->comment('联系方式');
            $table->string('city')->default('')->comment('地区');
            $table->string('payment')->default('')->comment('支付方式');
            $table->string('accountnumber')->default('')->comment('账户号码');
            $table->string('accountname')->default('')->comment('账户人');
            $table->string('banknumber')->default('')->comment('银行卡号');
            $table->string('bankname')->default('')->comment('银行卡名称');
            $table->string('ip')->comment('登录ip');            
            $table->integer('status')->default(0)->index()->comment('提取状态 0 申请未到账 1 已到账');
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
        Schema::dropIfExists('income');
    }
}
