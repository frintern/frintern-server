<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMenteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('mentees', function(Blueprint $table){
            $table->integer('experience_level'); // 0 for beginner, 1 for intermediate, 2 for advanced
            $table->integer('is_a_student');
            $table->string('organisation');
            $table->string('job_title');
            $table->softDeletes();
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
