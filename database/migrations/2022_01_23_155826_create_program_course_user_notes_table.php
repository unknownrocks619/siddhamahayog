<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramCourseUserNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_course_user_notes', function (Blueprint $table) {
            $table->id();
            $table->string("program_id");
            $table->string("program_course_id");
            $table->string("program_chapter_lession_id")->nullable();
            $table->longText('note')->nullable();
            $table->string('type')->deafult('document')->comment('available options draft.');
            $table->string("access")->default("private")->comment("available options: private, public");
            $table->string("remarks")->nullable();
            $table->timestamps();
            $table->softDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_course_user_notes');
    }
}
