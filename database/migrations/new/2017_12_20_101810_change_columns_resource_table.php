<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('resources', function($table) {
            $table->text('image_link')->nullable()->default(null)->change();
            $table->text('video_link')->nullable()->default(null)->change();
            $table->text('audio_link')->nullable()->default(null)->change();
            $table->text('file_link')->nullable()->default(null)->change();
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
