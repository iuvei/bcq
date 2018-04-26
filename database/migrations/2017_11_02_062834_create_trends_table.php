<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trends', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->string('title')->nullable()->comment('标题');
            $table->text('content')->comment('内容');
            $table->string('product_url')->nullable()->comment('产品官网');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedInteger('view')->default(0)->comment('浏览量');
            $table->unsignedInteger('uid')->nullable()->index()->comment('用户id');
            $table->string('type')->nullable()->comment('产品类别*****');//web 1 安卓 2 ios 3
            $table->tinyInteger('status')->default(1)->comment('状态：-1删除，0审核，1启用');
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
        Schema::dropIfExists('trends');
    }
}
