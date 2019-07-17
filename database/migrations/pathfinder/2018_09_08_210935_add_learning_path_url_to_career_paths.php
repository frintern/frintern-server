<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLearningPathUrlToCareerPaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('career_paths', function (Blueprint $table) {
            $table->text('learning_path_url')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('career_paths', function (Blueprint $table) {
            Schema::dropColumn('learning_path_url');
        });
    }
}
