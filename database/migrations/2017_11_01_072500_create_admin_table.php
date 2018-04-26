<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('name')->comment('用户名');
            $table->string('password')->nullable()->comment('密码');
            $table->tinyInteger('group')->unsigned()->default(0)->comment('用户组');
            $table->string('regip')->nullable()->comment('注册ip');
            $table->string('lastloginip')->nullable()->comment('最后登录ip');
            $table->rememberToken();
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
        Schema::dropIfExists('admin');
    }
}
