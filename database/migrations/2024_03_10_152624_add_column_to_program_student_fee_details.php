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
            $table->string('exchange_rate')->default(1)->after('foreign_currency_amount');
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
            $table->dropColumn('exchange_rate');
        });
    }
};
