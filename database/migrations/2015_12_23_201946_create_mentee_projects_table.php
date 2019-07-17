<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenteeProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create pivot table for the project and mentee
        Schema::create('mentee_projects', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('mentee_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->foreign('mentee_id')->references('id')->on('mentees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('status')->unsigned();
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
        // Drop Pivot table
        Schema::drop('mentee_projects');
    }
}
