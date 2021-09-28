<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUserAnswersSubmits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_answers_submits', function (Blueprint $table) {
            //
            // $table->string('user_login_id')->nullable();
            // $table->string('user_detail_id')->nullable();
            // $table->string("user_answer_id");
            $table->string('subjective_answer_upload')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_answers_submits', function (Blueprint $table) {
            //
        });
    }
}
