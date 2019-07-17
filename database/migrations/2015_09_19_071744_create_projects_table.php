<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates projects table
        Schema::create('projects', function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('type'); // enum: INDIVIDUAL, TEAM
            $table->integer('type_id'); // user_id or team_id
            $table->string('undertaken_by');
            $table->integer('has_image');
            $table->integer('has_video');
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
        // Drops the projects table
        Schema::drop('projects');
    }
}
