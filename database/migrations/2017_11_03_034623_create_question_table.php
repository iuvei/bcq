<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('用户id');
            $table->unsignedInteger('rid')->nullable()->index()->comment('采纳答案');
            $table->string('title')->nullable()->comment('标题');
            $table->text('describe')->comment('描述');
            $table->integer('price')->nullable()->comment('悬赏种子');
            $table->unsignedInteger('view')->default(0)->comment('浏览量');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('question');
    }
}
