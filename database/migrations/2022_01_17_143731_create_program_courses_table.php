<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_courses', function (Blueprint $table) {
            $table->id();
            $table->string("course_name");
            $table->string('slug');
            $table->string('program_id')->index();
            $table->string("total_chapters")->nullable();
            $table->boolean("enable_resource")->default(true)->nullable();
            $table->longText("description")->nullable();
            $table->boolean("public_visible")->default(true);
            $table->boolean("lock")->default(false);
            $table->boolean("sort")->nullable();
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
        Schema::dropIfExists('program_courses');
    }
}
