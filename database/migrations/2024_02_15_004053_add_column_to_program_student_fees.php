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
            $table->integer('program_student_id')->after('program_id')->nullable()->index();
            $table->integer('student_batch_id')->after('program_student_id')->nullable()->index();
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
            $table->dropColumn(['program_student_id','student_batch_id']);
        });
    }
};
