<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAnswersSubmitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answers_submits', function (Blueprint $table) {
            $table->id();
            $table->longText('user_answers')->nullable();
            $table->string("question_collection_id");
            $table->string('sibir_record_id');
            $table->string('question_id');
            $table->string('question_type')->nullable();
            $table->string('is_correct')->nullable();
            $table->string('obtained_marks')->nullable();
            $table->boolean('marks_verified')->default(true);
            $table->string('subjective_answer')->nullable();
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
        Schema::dropIfExists('user_answers_submits');
    }
}
