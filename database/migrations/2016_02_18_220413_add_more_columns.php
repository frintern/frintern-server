<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add more columns
//        Schema::table('user_interest_areas', function(Blueprint $table){
//
//            $table->integer('mentoring_area_id')->unsigned()->after('user_id');
//            $table->foreign('mentoring_area_id')->references('id')->on('mentoring_areas')->onUpdate('cascade')->onDelete('cascade');
//
//        });
//
//        Schema::table('resources', function(Blueprint $table){
//
//            $table->integer('mentoring_area_id')->unsigned()->after('user_id');
//            $table->foreign('mentoring_area_id')->references('id')->on('mentoring_areas')->onUpdate('cascade')->onDelete('cascade');
//        });

//        Schema::table('mentors_expertise_areas', function(Blueprint $table){
//
//            $table->foreign('mentoring_area_id')->references('id')->on('mentoring_areas')->onUpdate('cascade')->onDelete('cascade');
//        });


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
