<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('applicant_author', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->increments('id');
            $table->unsignedInteger('uid')->nullable()->index()->comment('用户id');
            $table->string('name')->nullable()->comment('怎么称呼');
            $table->string('phone')->nullable()->comment('联系电话');
            $table->string('interest')->nullable()->comment('所在领域');
            $table->string('desc')->nullable()->comment('申请理由');
            $table->string('links')->nullable()->comment('您的相关文章链接');
            $table->string('addip')->nullable()->comment('注册ip');
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
        Schema::dropIfExists('user_author');
    }
}
