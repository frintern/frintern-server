<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create projects table
        Schema::create('projects', function(Blueprint $table){

            $table->increments('id');
            $table->integer('mentor_id')->unsigned();
            $table->foreign('mentor_id')->references('id')->on('mentors')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->longText('background');
            $table->longText('description');
            $table->integer('duration');
            $table->string('online_resource');
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
        // Drop the projects table
        Schema::drop('projects');
    }
}
