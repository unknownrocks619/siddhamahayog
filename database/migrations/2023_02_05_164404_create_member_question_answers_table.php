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
        Schema::create('member_question_answers_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('program_id');
            $table->string('member_id')->nullable();
            $table->string('program_exam_id');
            $table->string('program_exam_question_id');
            $table->string('member_answer_overview_id')->nullable();
            $table->longText('exam_detail')->comment('cachel all exam detail.');
            $table->longText('question_detail')->comment('cache all questions');
            $table->longText('answer')->nullable();
            $table->string('status')->default('draft')->comment('available options: draft, discard, completed.');
            $table->longText('result')->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_question_answers_detail');
    }
};
