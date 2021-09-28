<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventVideoClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_video_classes', function (Blueprint $table) {
            $table->id();
            $table->string("event_id");
            $table->string('class_start');
            $table->string('class_end');
            $table->boolean('is_active')->default(false);
            $table->string('meeting_id')->nullable();
            $table->string('password')->nullable();
            $table->text('video_link')->nullable();
            $table->string('class_source')->default("zoom");
            $table->timestamps();
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
        Schema::dropIfExists('event_video_classes');
    }
}
