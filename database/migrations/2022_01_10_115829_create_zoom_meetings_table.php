<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();
            $table->string("zoom_accounts_id")->comment("Foreign Key: Table: zoom_accounts");
            $table->string("meeting_name");
            $table->string('slug');
            $table->string("meeting_type")->comment("available options: scheduled:1,instant:2,re-occuring:3");
            $table->boolean('daily_register')->default(false);
            $table->string("timezone")->nullable()->comment("zoom available timezone.");
            $table->boolean('meeting_created')->default(false);
            $table->boolean("completed")->default(false);
            $table->text("scheduled_timestamp")->nullable();
            $table->text("repetition_setting")->nullable();
            $table->boolean("user_registered")->default(false);
            $table->boolean('live')->default(false);
            $table->boolean('lock')->default(false);
            $table->string("lock_setting")->nullable();
            $table->longText("remarks")->nullable();
            $table->boolean("country_specified")->nullable();
            $table->string("meeting_by")->nullable()->comment("is nullable if meeting was created by admin.");
            $table->string("created_by")->nullable()->comment('track who created this created.');
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
        Schema::dropIfExists('zoom_meetings');
    }
}
