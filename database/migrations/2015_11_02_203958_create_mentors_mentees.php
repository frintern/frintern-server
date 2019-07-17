<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorsMentees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the tables stores the relationship between mentors and mentees
        Schema::create('mentors_mentees', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mentor_id')->unsigned();
            $table->integer('mentee_id')->unsigned();
            $table->foreign('mentor_id')->references('id')->on('mentors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('mentee_id')->references('id')->on('mentees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('mentoring_topic');
            $table->longText('description');
            $table->dateTime('mentoring_starts');
            $table->dateTime('mentoring_ends');
            $table->integer('contact_hours_per_week');
            $table->integer('contact_day');
            $table->time('contact_time');
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
        //
    }
}
