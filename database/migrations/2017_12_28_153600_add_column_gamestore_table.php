<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnGamestoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gamestore', function (Blueprint $table) {
            $table->Integer('money')->default(0)->after('url');
            $table->Integer('access_point')->default(0)->after('money');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumn('money');
        Schema::dropColumn('access_point');
    }
}
