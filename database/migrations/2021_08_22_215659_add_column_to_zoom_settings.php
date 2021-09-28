<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToZoomSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zoom_settings', function (Blueprint $table) {
            //
            $table->boolean('is_active')->default(false);
            $table->string('sibir_record_id')->index()->nullable();
            $table->string('meeting_id')->nullable();
            $table->boolean('is_used')->nullable();
            $table->string('start_time')->nullable();
            $table->string('timezone')->nullable();
            $table->text("admin_start_url")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zoom_settings', function (Blueprint $table) {
            //
        });
    }
}
