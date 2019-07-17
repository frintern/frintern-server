<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMentorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('mentors', function(Blueprint $table){
            $table->string('current_position');
            $table->text('description');
            $table->integer('hours_per_week');
            $table->string('company_name');
            $table->string('job_title');
            $table->longText('why_mentor');
            $table->integer('has_mentorship_experience');
            $table->longText('mentorship_experience_desc');
            $table->text('video_url');
            $table->string('website_url');
            $table->string('timezone');
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
