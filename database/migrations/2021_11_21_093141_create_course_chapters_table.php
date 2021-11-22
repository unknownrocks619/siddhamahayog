<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_chapters', function (Blueprint $table) {
            $table->id();
            $table->string('sibir_record_id');
            $table->string("chapter_name");
            $table->string("chapter_slug")->unique();
            $table->longText("description")->nullable();
            $table->string('total_lessions')->default(0);
            $table->boolean("active")->default(true);
            $table->boolean('locked')->default(false);
            $table->string('sort_by')->nullable();
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
        Schema::dropIfExists('course_chapters');
    }
}
