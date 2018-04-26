<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components_config', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->index()->nullable()->comment('页面id');
            $table->integer('cid')->index()->nullable()->comment('组件idcomponent_id 右边栏组件id，组件与id对应关系（special 1,news 2,user_data 3, report 4, business 5, platform 6, author 7
）');
            $table->string('title')->nullable()->comment('组件页面标题');
            $table->integer('sort')->default(0)->comment('组件顺序');
            $table->integer('status')->default(0)->comment('0停用 1启用');
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
        Schema::dropIfExists('components_config');
    }
}
