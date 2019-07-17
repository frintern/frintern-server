<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenteeActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create table for mentee activities
        Schema::create('mentee_activities', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mentee_id')->unsigned();
            $table->foreign('mentee_id')->references('id')->on('mentees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('description');
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
        // Drop the mentee activities table
        Schema::drop('mentee_activities');
    }
}
