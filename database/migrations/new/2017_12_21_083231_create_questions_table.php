<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('questions', function(Blueprint $table) {
            $table->increments('id');
            $table->longText('body');
            $table->integer('asked_by')->unsigned();
            $table->integer('directed_to')->unsigned();
            $table->foreign('asked_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('flagged')->default(false);
            $table->boolean('active')->default(true);
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
        Schema::drop('questions');
    }
}
