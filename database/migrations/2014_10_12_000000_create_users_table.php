<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('username')->nullable()->comment('用户名');
            $table->string('password')->nullable()->comment('密码');
            $table->unsignedTinyInteger('level_id')->default(1)->comment('用户等级');
            $table->unsignedTinyInteger('vip')->default(0)->comment('VIP：1是，0否');
            $table->unsignedInteger('price')->default(0)->comment('持有种子');
            $table->unsignedInteger('viptime')->nullable()->comment('VIP到期时间');
            $table->unsignedInteger('regdate')->nullable()->comment('注册时间');
            $table->string('regip')->nullable()->comment('注册ip');
            $table->unsignedInteger('lastlogindate')->nullable()->comment('操作时间');
            $table->string('lastloginip')->nullable()->comment('最后登录ip');
            $table->string('image')->nullable()->comment('用户头像');
            $table->string('brief')->nullable()->comment('个人简介');
            $table->string('phone')->nullable()->unique()->comment('电话');
            $table->string('skype')->nullable()->comment('skype');
            $table->string('email')->nullable()->comment('email');
            $table->unsignedTinyInteger('email_verify')->default(1)->index()->comment('邮箱验证');
            $table->string('wechat')->nullable()->comment('wechat');
            $table->string('qq')->nullable()->comment('qq');
            $table->string('job')->nullable()->comment('job');
            $table->string('grasp')->nullable()->comment('掌握资源');
            $table->string('city')->nullable()->comment('所在城市');
            $table->rememberToken();
            $table->tinyInteger('status')->default(1)->index()->comment('状态：-1删除，0审核/禁用，1启用');
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
        Schema::dropIfExists('users');
    }
}
