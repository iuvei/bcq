<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   //企业库
        Schema::create('enterprise', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedInteger('famous')->default(0)->comment('名企：0否，1是');
            $table->tinyInteger('scale')->nullable(0)->comment('规模');
            $table->tinyInteger('region')->nullable(0)->comment('地区');
            $table->unsignedInteger('view')->default(0)->comment('浏览次数');
            $table->string('addip')->nullable()->comment('添加ip');
            $table->string('title')->nullable()->comment('企业名称');
            $table->text('content')->comment('企业简介');
            $table->string('logo')->nullable()->comment('企业logo');
            $table->string('url')->nullable()->comment('博招聘外链地址');
            $table->tinyInteger('status')->default(0)->comment('状态：-1删除，0禁用，1启用');
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
        Schema::dropIfExists('enterprise');
    }
}
