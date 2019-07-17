<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('program_resource', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('program_id')->unsigned();
           $table->integer('resource_id')->unsigned();
           $table->foreign('program_id')->references('id')->on('programs')->onUpdate('cascade')->onDelete('cascade');
           $table->foreign('resource_id')->references('id')->on('resources')->onUpdate('cascade')->onDelete('cascade');
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
        //
    }
}
