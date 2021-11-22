<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToOfflineVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_videos', function (Blueprint $table) {
            //
            $table->string("course_chapter_id")->nullable();
            $table->string("total_video_time")->nullable();
            $table->string('sortable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offline_videos', function (Blueprint $table) {
            //
        });
    }
}
