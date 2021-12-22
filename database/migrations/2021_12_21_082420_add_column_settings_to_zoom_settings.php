<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSettingsToZoomSettings extends Migration
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
            $table->string('meeting_type')
                    ->nullable()
                    ->default("course")
                    ->comment("Available options: course, sibir group,registration,open, selected group");
            $table->string('additional_setting')
                    ->nullable()->comment('for additional future settings');
            
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
