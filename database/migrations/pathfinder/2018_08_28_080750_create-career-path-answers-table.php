<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerPathAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_path_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('career_path_question_id')->unsigned();
            $table->foreign('career_path_question_id')->references('id')->on('career_path_questions')->onUpdate('cascade')->onDelete('cascade');
            $table->text('text');
            $table->integer('career_path_category_id')->unsigned();
            $table->foreign('career_path_category_id')->references('id')->on('career_path_categories')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('career_path_answers');
    }
}
