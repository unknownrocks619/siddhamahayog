<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramCourseResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_course_resources', function (Blueprint $table) {
            $table->id();
            $table->string("program_id");
            $table->string("program_course_id");
            $table->string("resource_title")->nullable();
            $table->string('slug')->nullable();
            $table->string("resource_type")->nullable()->comment("text",'pdf','image');
            $table->longText("description")->nullable();
            $table->string("resource")->nullable();
            $table->boolean("lock")->default(false);
            $table->boolean('lock_after')->nullable()->comment("no. of days after upload.");
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
        Schema::dropIfExists('program_course_resources');
    }
}
