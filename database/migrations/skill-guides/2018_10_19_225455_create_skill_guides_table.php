<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_guides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('career_path_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->longText('content');
            $table->integer('stage');
            $table->enum('level', ['beginner', 'intermediate', 'expert']);
            $table->integer('author_id')->unsigned();
            $table->foreign('career_path_id')->references('id')->on('career_paths')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('skill_guides');
    }
}
