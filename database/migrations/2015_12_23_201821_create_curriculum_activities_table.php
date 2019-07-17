<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculumActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create Curriculum Activities
        Schema::create('curriculum_activities', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('curriculum_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->foreign('curriculum_id')->references('id')->on('curriculums')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onUpdate('cascade')->onDelete('cascade');
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
        // Drop the curriculum activities
        Schema::drop('curriculum_activities');

    }
}
