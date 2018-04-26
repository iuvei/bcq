<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompanyComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->default('')->comment('用户名');
            $table->string('image')->default('')->comment('用户头像');
            
            $table->integer('type')->nullable()->comment('评企类型');//1点评分享 2薪资分享 3面试经分享 4办公环境分享
            $table->string('company')->default('')->comment('公司名');            

            $table->string('title')->default('')->comment('标题');            
            $table->string('comment')->default('')->comment('评价');            
                     
            $table->string('position')->default('')->comment('职位');
            $table->string('wage_year')->default('')->comment('年工资');
            $table->string('wage_month')->default('')->comment('月工资');
            $table->string('bonus')->default('')->comment('年终奖');
            $table->string('food')->default('')->comment('餐补');
            $table->string('rent')->default('')->comment('房补');
            $table->string('ticket')->default('')->comment('机票补贴');

            $table->string('inter_position')->default('')->comment('面试职位');
            $table->string('inter_type')->default('')->comment('面试方式');
            $table->string('inter_cycle')->default('')->comment('面试周期');
            $table->string('inter_level')->default('')->comment('面试难度');
            $table->string('inter_ret')->default('')->comment('面试结果');

            $table->text('environment')->comment('公司环境');
            
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
        Schema::dropIfExists('company_comments');
    }
}
