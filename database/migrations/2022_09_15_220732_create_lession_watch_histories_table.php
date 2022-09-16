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
        Schema::create('lession_watch_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained("members", "id");
            $table->foreignId("program_id")->constrained("programs", "id");
            $table->foreignId("program_course_id")->constrained("program_courses", "id")->nullable();
            $table->foreignId("program_chapter_lession_id")->constrained("program_chapter_lessions", "id");
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
        Schema::dropIfExists('program_lession_watch_histories');
    }
};
