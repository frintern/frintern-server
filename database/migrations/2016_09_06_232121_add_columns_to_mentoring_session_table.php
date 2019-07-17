<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMentoringSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mentoring_sessions', function (Blueprint $table) {
            //
            $table->dateTime('start_time')->after('status');
            $table->dateTime('end_time')->after('start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mentoring_sessions', function (Blueprint $table) {
            //
        });
    }
}
