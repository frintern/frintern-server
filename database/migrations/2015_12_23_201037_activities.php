<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create activities table
        Schema::create('activities', function(Blueprint $table){
            $table->increments('id');
            $table->integer('mentor_id')->unsigned();
            $table->foreign('mentor_id')->references('id')->on('mentors')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->longText('description');
            $table->longText('task');
            $table->string('online_resource');
            $table->integer('duration')->unsigned(); // in terms of number of weeks
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
        // Drop activities table
        Schema::drop('activities');
    }
}
