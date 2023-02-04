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
        Schema::create('program_exam_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('program_id')->index();
            $table->foreignId('program_exam_id')->constrained('program_exams', 'id');
            $table->text('question_title');
            $table->longText('description')->nullable();
            $table->string('question_type')->default('subjective');
            $table->longText('question_detail')->nullable();
            $table->text('marks')->nullable();
            $table->longText('category')->nullable();
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
        Schema::dropIfExists('program_exam_questions');
    }
};
