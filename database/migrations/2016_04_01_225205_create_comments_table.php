<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create comments table
        Schema::create('comments', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned(); // author of the comment
            $table->integer('resource_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('resource_id')->references('id')->on('resources')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('parent_id');
            $table->integer('root_id');
            $table->longText('content');
            $table->integer('active'); // 1 or 0
            $table->timestamps();
        });

        Schema::create('comment_votes', function(Blueprint $table){
            $table->increments('id');
            $table->integer('comment_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('type'); // 1 for upvote, 0 is downvote
            $table->timestamps();
        });

        Schema::create('resource_views', function(Blueprint $table){
            $table->increments('id');
            $table->integer('resource_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('resource_votes', function(Blueprint $table){
            $table->increments('id');
            $table->integer('resource')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('type'); // 1 for upvote, 0 is downvote
            $table->timestamps();
        });

        Schema::create('questions', function(Blueprint $table){
            $table->increments('id');
            $table->integer('resource_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('resource_id')->references('id')->on('resources')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('content');
            $table->integer('active');
            $table->timestamps();
        });

        Schema::create('questions_votes', function(Blueprint $table){
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('type');
            $table->timestamps();
        });


        Schema::create('answers', function(Blueprint $table){
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('content');
            $table->integer('active');
            $table->timestamps();

        });

        Schema::create('answer_votes', function(Blueprint $table){
            $table->increments('id');
            $table->integer('answer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('answer_id')->references('id')->on('answers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('type');
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
        // Drop Comments table
        Schema::drop('comments');

        // Drop questions
        Schema::drop('questions');

        // Drop answers
        Schema::drop('answers');
    }
}
