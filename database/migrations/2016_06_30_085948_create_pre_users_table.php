<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create pre users table
        Schema::create('pre_users', function(Blueprint $table){
            $table->increments('id');
            $table->string('email')->unique();
            $table->integer('user_type'); // 1 for mentee, 2 for mentor and 3 for both
            $table->integer('status'); // 0 for not registered, 1 for register user
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
        // Drop pre users table
        Schema::drop('pre_users');
    }
}
