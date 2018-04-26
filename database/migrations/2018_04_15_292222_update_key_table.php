<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('key', function (Blueprint $table) {
            $table->unsignedInteger('num')->default(0)->after('view')->comment('总频率');
            $table->tinyInteger('status')->default(1)->after('num')->comment('状态：0禁用，1启用');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
