<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOfflineVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('offline_videos', function (Blueprint $table) {
        //     //
        //     $table->boolean('is_private')->default(true)->comment('available options');
        //     $table->string('video_type')->nullable()->comment("available options, private, protected and public");
        // });
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
