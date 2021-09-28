<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSadhakUniqueZoomRegistrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sadhak_unique_zoom_registrations', function (Blueprint $table) {
            //
            $table->string('registration_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sadhak_unique_zoom_registrations', function (Blueprint $table) {
            //
        });
    }
}
