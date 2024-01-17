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
        Schema::table('dharmasala_bookings', function (Blueprint $table) {
            //
            $table->string('check_in_time')->nullable()->after('check_in');
            $table->string('check_out_time')->nullable()->after('check_out');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dharmasala_bookings', function (Blueprint $table) {
            //
            $table->dropColumn(['check_in_time','check_out_time']);
        });
    }
};
