<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->string('sibir_record_id');
            $table->string('question_collection_id');
            $table->string('marks_obtained')->nullable();
            $table->string('user_detail_id')->nullable();
            $table->string('user_login_id')->nullable();
            $table->string('total_attempt')->nullable();
            $table->string('total_correct')->nullable();
            $table->string('total_incorrect')->nullable();
            $table->string('display')->nullable();
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
        Schema::dropIfExists('user_answers');
    }
}
