<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentoringObjectiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates table for mentoring objectives
        Schema::create('mentoring_objectives', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mentee_mentor_id')->unsigned();
            $table->foreign('mentee_mentor_id')->references('id')->on('mentors_mentees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->longText('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drops the table
        Schema::drops('mentoring_activities');
    }
}
