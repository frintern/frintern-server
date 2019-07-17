<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerPathTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_paths', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('career_path_category_id')->unsigned();
            $table->foreign('career_path_category_id')->references('id')->on('career_path_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description');
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
        Schema::drop('career_paths');
    }
}
