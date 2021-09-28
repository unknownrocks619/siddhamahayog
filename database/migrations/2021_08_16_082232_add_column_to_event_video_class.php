<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToEventVideoClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_video_classes', function (Blueprint $table) {
            //
            $table->boolean('meeting_lock')->default(false);
            $table->string('lock_after')->nullable();
            $table->text('meeting_lock_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_video_class', function (Blueprint $table) {
            //
        });
    }
}
