<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_title');
            $table->string('course_description')->nullable();
            $table->string('course_start_from')->nullable();
            $table->string('course_end')->nullable();
            $table->string('course_fee')->nullable();
            $table->boolean('is_free')->default(false);
            $table->boolean('is_paid')->default(true);
            $table->boolean("is_admission_started")->default(false);
            $table->string('payment_type')->default('monthly')->comment("available options");
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
        Schema::dropIfExists('courses');
    }
}
