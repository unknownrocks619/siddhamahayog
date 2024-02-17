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
        Schema::table('program_student_fee_details', function (Blueprint $table) {
            //
            $table->string('fee_added_by_center')->nullable();
            $table->string('voucher_number')->after('rejected')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_student_fee_details', function (Blueprint $table) {
            //
            $table->dropColumn(['fee_added_by_center','voucher_member']);
        });
    }
};
