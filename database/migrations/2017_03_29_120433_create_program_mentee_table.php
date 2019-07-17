<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramMenteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_mentee', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('program_id')->unsigned();
            $table->integer('mentee_id')->unsigned();
            $table->foreign('program_id')->references('id')->on('programs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('mentee_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_active');
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
        Schema::drop('program_mentee');
    }
}
