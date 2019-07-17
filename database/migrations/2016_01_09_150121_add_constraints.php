<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add constraints

        // Add program Id as constraint on the program activities table
        Schema::table('program_activities', function(Blueprint $table)
        {
            $table->integer('program_id')->unsigned()->after('id');
            $table->foreign('program_id')->references('id')->on('programs');
        });

        // Mentee program table
        Schema::table('mentee_program', function(Blueprint $table)
        {
            $table->integer('program_id')->unsigned()->after('id');
            $table->foreign('program_id')->references('id')->on('programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
