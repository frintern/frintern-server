<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('videos', function(Blueprint $table){
            $table->increments('id');
            $table->string('entity_type'); // enum: PROJECT, TASK, REPORT
            $table->integer('entity_type_id'); // project_id | task_id | report_id
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
        // Drops videos table
        Schema::drop('videos');
    }
}
