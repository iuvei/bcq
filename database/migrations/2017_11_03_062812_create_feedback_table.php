<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('用户id');
            $table->string('title')->nullable()->comment('标题');
            $table->string('content')->nullable()->comment('内容');
            $table->string('addip')->nullable()->comment('留言ip');
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
        Schema::dropIfExists('feedback');
    }
}
