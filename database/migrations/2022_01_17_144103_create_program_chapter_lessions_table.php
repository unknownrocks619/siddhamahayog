<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramChapterLessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_chapter_lessions', function (Blueprint $table) {
            $table->id();
            $table->string('program_course_id')->index();
            $table->string("program_id")->index();
            $table->string("lession_name");
            $table->string("slug")->nullable();
            $table->string('total_duration')->nullable();
            $table->string("total_credit")->nullable();
            $table->enum("lession_output",["online","physical"])->default('online');
            $table->enum("online_medium",["vimeo","youtube",'upload'])->default('vimeo');
            $table->string("video_total_duration")->nullable();
            $table->string("lession_date")->nullable();
            $table->string('video_lock')->default(false);
            $table->string("lock_after")->nullable()->comment("No of days, with respect to created at or lession_date");
            $table->longText("video_description")->nullable();
            $table->string("status")->default("active")->comment("Current Lession status.");
            $table->string("sort")->nullable();
            $table->string('video_link')->nullable();
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
        Schema::dropIfExists('program_chapter_lessions');
    }
}
