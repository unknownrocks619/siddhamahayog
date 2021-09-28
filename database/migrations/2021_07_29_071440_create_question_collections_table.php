<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_collections', function (Blueprint $table) {
            $table->id();
            $table->string("sibir_record_id")->nullable()->comment("question for event");
            $table->string("class_id")->nullable();
            $table->string('course_id')->nullable();
            $table->string('question_term')->nullable();
            $table->string("question_term_slug")->nullable();
            $table->string('total_marks')->nullable();
            $table->string('total_objective')->nullable();
            $table->string('total_subjective')->nullable();            
            $table->boolean('sortable')->default(true);
            $table->string("exam_start_date")->nullable();
            $table->string("exam_end_date")->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('total_exam_time');
            $table->string('question_paper_name')->nullable();
            $table->string('question_paper_name_slug')->slug()->nullable();
            $table->longText('description')->nullable();
            $table->string('user_login_id');
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
        Schema::dropIfExists('question_collections');
    }
}
