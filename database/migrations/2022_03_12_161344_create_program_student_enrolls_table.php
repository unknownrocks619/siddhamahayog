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
        Schema::create('program_student_enrolls', function (Blueprint $table) {
            $table->id();
            $table->string('program_id');
            $table->string("member_id");
            $table->string("enroll_date");
            $table->string('program_course_fee_id');
            $table->boolean('scholarship')->default(false);
            $table->text('scholarship_document')->nullable();
            $table->string("scholarship_cause")->nullable();
            $table->string("scholarship_type")->default('full')->commentt('available options: full, admission, monthly');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_student_enrolls');
    }
};
