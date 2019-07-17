<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentoringRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create mentoring request table
        Schema::create('mentoring_requests', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('request_from')->unsigned();
            $table->integer('request_to')->unsigned();
            $table->foreign('request_from')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('request_to')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('message');
            $table->string('relationship');
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
        // Drop table
        Schema::drop('mentoring_requests');
    }
}
