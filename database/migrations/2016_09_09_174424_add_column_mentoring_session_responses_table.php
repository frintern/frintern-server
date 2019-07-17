<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMentoringSessionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mentoring_session_responses', function (Blueprint $table) {
            //
            $table->integer('mentoring_session_id')->unsigned();
            $table->foreign('mentoring_session_id')->references('id')->on('mentoring_sessions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mentoring_session_responses', function (Blueprint $table) {
            //
        });
    }
}
