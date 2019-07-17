<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates reports tabled
        Schema::create('reports', function(Blueprint $table){
            $table->increments('id');
            $table->string('entity_type'); // enum: TASK , PROJECT
            $table->integer('entity_type_id'); // task_id or project_id
            $table->integer('has_image');
            $table->integer('has_video');
            $table->integer('submitted_by');
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
        // Drops the reports table
        Schema::drop('reports');
    }
}
