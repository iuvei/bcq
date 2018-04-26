<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('发布者id');
            $table->unsignedInteger('type')->nullable()->comment('商讯类型：1供应，2求购');
            $table->unsignedInteger('bid')->nullable()->comment('服务类型：商讯分类表');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedTinyInteger('hot')->default(0)->comment('推荐：0否，1是');
            $table->unsignedTinyInteger('confirm')->default(0)->comment('认证：0否，1是');
            $table->unsignedInteger('money')->default(0)->comment('保证金');
            $table->unsignedInteger('top')->default(0)->comment('点赞');
            $table->unsignedInteger('view')->default(0)->comment('浏览次数');
            $table->unsignedInteger('validitytime')->nullable()->comment('有效时间');
            $table->string('title')->nullable()->comment('标题');
            $table->string('url')->nullable()->comment('产品网址');
            $table->text('pic')->comment('图片地址');
            $table->text('content')->comment('详情');
            $table->string('contactperson')->nullable()->comment('联系人');
            $table->string('phone')->nullable()->comment('电话');
            $table->string('skype')->nullable()->comment('skype');
            $table->string('qq')->nullable()->comment('qq');
            $table->string('wechat')->nullable()->comment('wechat');
            $table->string('email')->nullable()->comment('email');
            $table->string('enterprise')->nullable()->comment('平台名称');
            $table->string('logo')->nullable()->comment('平台logo');
            $table->string('brief')->nullable()->comment('平台简介');
            $table->string('personnel')->nullable()->comment('认证人员');
            $table->tinyInteger('plate')->nullable()->default(0)->comment('持有证书');
            $table->tinyInteger('year')->nullable()->default(0)->comment('年限');
            $table->tinyInteger('scale')->nullable()->default(0)->comment('规模');
            $table->tinyInteger('status')->default(0)->comment('状态：-1删除，0审核，1启用');
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
        Schema::dropIfExists('business');
    }
}
