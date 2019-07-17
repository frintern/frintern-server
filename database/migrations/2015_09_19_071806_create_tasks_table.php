<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tasks', function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->integer('undertaken_by');
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
        // Drops the tasks table
        Schema::drop('tasks');
    }
}
