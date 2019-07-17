<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function(Blueprint $table){
            $table->text('about');
            $table->string('headline');
            $table->string('twitter_id');
            $table->string('twitter_handle');
            $table->string('facebook_id');
            $table->string('facebook_name');
            $table->string('linkedin_id');
            $table->string('avatar_uri');
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
