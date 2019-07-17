<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         // create table for mentor activities
        Schema::create('mentor_activities', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mentor_id')->unsigned();
            $table->foreign('mentor_id')->references('id')->on('mentees')->onUpdate('cascade')->onDelete('cascade');
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
        // Drop mentor activities table
        Schema::drop('mentor_activities');
    }
}
