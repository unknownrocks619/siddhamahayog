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
        Schema::table('member_under_links', function (Blueprint $table) {

            $table->unsignedBigInteger('teacher_training_id')->after('student_id');
            $table->unsignedBigInteger('enrolled_by')->nullable()->after('teacher_training_id');
            $table->string('enrolled_type')->default('user')->after('enrolled_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_under_links', function (Blueprint $table) {
            $table->dropColumn(['teacher_training_id', 'enrolled_by', 'enrolled_type']);
        });
    }
};
