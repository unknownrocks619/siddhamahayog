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
        Schema::create('program_exams', function (Blueprint $table) {
            $table->id();
            $table->string('program_id')->index();
            $table->longText('title');
            $table->boolean('enable_time')->default(false);
            $table->boolean('active')->default(true);
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->longText('description')->nullable();
            $table->string('full_marks')->nullable();
            $table->string('pass_marks')->nullable();
            $table->string('total_questions')->nullable();
            $table->longText("question_by_category")->nullable();
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
        Schema::dropIfExists('program_exams');
    }
};
