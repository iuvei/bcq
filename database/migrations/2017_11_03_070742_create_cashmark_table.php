<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashmarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashmark', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('cid')->nullable()->index()->comment('现金网id');
            $table->tinyInteger('mark1')->default(0)->comment('评分1');
            $table->tinyInteger('mark2')->default(0)->comment('评分2');
            $table->tinyInteger('mark3')->default(0)->comment('评分3');
            $table->tinyInteger('mark4')->default(0)->comment('评分4');
            $table->string('addip')->nullable()->comment('添加ip');
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
        Schema::dropIfExists('cashmark');
    }
}
