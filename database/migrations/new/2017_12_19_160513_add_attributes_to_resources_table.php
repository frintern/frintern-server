<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributesToResourcesTable extends Migration
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
            $table->text('video_link');
            $table->text('image_link');
            $table->text('audio_link');
            $table->text('file_link');
            $table->dropColumn('featured_image_uri');
            $table->dropColumn('views');
            $table->dropColumn('title');
            $table->dropColumn('uri');
            $table->dropForeign('resources_interest_id_foreign');
            $table->dropIndex('resources_interest_id_foreign');
            $table->dropColumn('interest_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('video_link');
        $table->dropColumn('image_link');
        $table->dropColumn('audio_link');
        $table->dropColumn('file_link');
        $table->text('feature_image_uri');
        $table->integer('views');
        $table->string('title');
        $table->text('uri');
        $table->integer('interest_id')->unsigned();
    }
}
