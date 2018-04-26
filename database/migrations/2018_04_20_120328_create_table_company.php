<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->default('')->comment('用户名');
            $table->string('image')->default('')->comment('用户头像');
            $table->string('company')->default('')->comment('公司名');            
            $table->string('logo')->default('')->comment('公司logo');           
            $table->string('position')->default('')->comment('职位');
            $table->string('edu')->default('')->comment('教育经历');
            $table->string('exp')->default('')->comment('年限');
            $table->string('num')->default('')->comment('人数');
            $table->string('city')->default('')->comment('城市');
            $table->string('wage')->default('')->comment('工资');
            $table->string('welfare')->default('')->comment('福利');             
            $table->tinyInteger('status')->default(0)->comment('状态：-1删除，0审核/禁用，1启用');
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
        Schema::dropIfExists('company');    
    }
}
