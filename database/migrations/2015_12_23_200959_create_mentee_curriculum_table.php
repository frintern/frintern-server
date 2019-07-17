<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenteeCurriculumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create pivot table for mentees and curriculum: stores the record of curriculum assigned to mentees
        Schema::create('mentee_curriculum', function(Blueprint $table){

            $table->increments('id');
            $table->integer('mentee_id')->unsigned();
            $table->integer('curriculum_id')->unsigned();
            $table->foreign('mentee_id')->references('id')->on('mentees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('curriculum_id')->references('id')->on('curriculums')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('status')->unsigned();
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
        // Drop Pivot table
        Schema::drop('mentee_curriculum');

    }
}
