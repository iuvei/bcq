<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageEditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_edit', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->engine = 'MyiSam';
            $table->increments('id');
            $table->integer('page_id')->nullable()->comment('页面id');
            $table->integer('component_id')->nullable()->comment('页面组件id');
            $table->integer('sort')->default(0)->comment('页面组件顺序');
            $table->timestamps();
            $table->unique(['page_id', 'component_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_edit');
    }
}
