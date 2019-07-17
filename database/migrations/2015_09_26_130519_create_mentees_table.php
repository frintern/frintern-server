<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creates the mentees table
        Schema::create('mentees', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('institution');
            $table->string('course');
            $table->string('level');
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
        // Drops mentees table
        Schema::drop('mentors');

    }
}
