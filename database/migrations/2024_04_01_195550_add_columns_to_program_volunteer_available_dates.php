<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_volunteer_available_dates', function (Blueprint $table) {
            //
            $table->string('remarks')->nullable()->after('status');
            $table->string('reporting_time')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_volunteer_available_dates', function (Blueprint $table) {
            //
            $table->dropColumn(['remarks','reporting_time']);
        });
    }
};
