<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_collection', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mid')->nullable()->index()->comment('微动态id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('用户id');
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
        Schema::dropIfExists('micro_collection');
    }
}
