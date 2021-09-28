<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_collections_id');
            $table->string('user_login_id');
            $table->string('question_type')->default('text')->comment('available options text, image, audio');
            $table->string("sibir_record_id")->nullable()->comment("question for event");
            $table->string("class_id")->nullable();
            $table->string('course_id')->nullable();
            $table->longText('question_title')->nullable();
            $table->string('alternate_question_title')->nullable();
            $table->string('total_point')->default(0)->nullable();
            $table->longText('objectives')->nullable();
            $table->string('correct_number')->nullable();
            $table->string('question_structure')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
