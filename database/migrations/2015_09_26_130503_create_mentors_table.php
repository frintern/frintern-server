<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // creates mentors table
        Schema::create('mentors', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('organisation');
            $table->string('mobile_number');
            $table->string('office_number');
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
        // Drop mentors table
        Schema::drop('mentors');
    }
}
