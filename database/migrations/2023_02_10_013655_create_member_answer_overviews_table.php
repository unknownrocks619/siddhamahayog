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
        Schema::create('member_answer_overviews', function (Blueprint $table) {
            $table->id();
            $table->string('program_id');
            $table->string('member_id');
            $table->string('question_collection_id');
            $table->longText('attempted_questions')->nullable();
            $table->string('total_marks_obtained')->nullable();
            $table->string('total_wrong_answer')->nullable();
            $table->string('total_right_answer')->nullable();
            $table->longText('certificates')->nullable();
            $table->longText('download')->nullable();
            $table->integer('status')->default(1);
            $table->longText("markings")->nullable();
            $table->longText('revisions')->nullable();
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
        Schema::dropIfExists('member_answer_overviews');
    }
};
