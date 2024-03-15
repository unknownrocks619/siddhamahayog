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
            $table->integer('member_emergency_meta_id')->nullable()->after('member_id');
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
            $table->dropColumn('member_emergency_meta_id');
        });
    }
};
