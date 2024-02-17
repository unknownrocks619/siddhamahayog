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
        Schema::table('program_student_fees', function (Blueprint $table) {
            //
            $table->string('full_name')->nullable()->after('total_amount');
            $table->string('full_address')->nullable()->after('full_name');
            $table->string('phone_number')->nullable()->after('full_address');
            // $table->integer('student_id')->nullable()->index()->change();
            // $table->integer('program_id')->index()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_student_fees', function (Blueprint $table) {
            //
            $table->dropColumn(['full_name','full_address']);
        });
    }
};
