<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToEventVideoAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_video_attendances', function (Blueprint $table) {
            //
            $table->string('source')->default("global")->comment("available options: global and zonal");
            $table->string('zonal_setting_id')->index()->nullable();
            $table->string('meeting_id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_video_attendances', function (Blueprint $table) {
            //
        });
    }
}
