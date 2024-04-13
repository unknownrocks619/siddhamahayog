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
            $table->boolean('marked_to_print')->default(0)->after('phone_number');
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
            $table->dropColumn(['marked_to_print']);
        });
    }
};
