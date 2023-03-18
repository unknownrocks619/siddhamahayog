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
        Schema::create('program_student_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId("program_id")->constrained("programs", "id");
            $table->foreignId("student")->constrained("members", "id");
            $table->foreignId("section_id")->nullable()->constrained("program_sections", "id");
            $table->foreignId("live_id")->constrained("lives", "id")->nullable();
            $table->string("meeting_id")->nullable();
            $table->boolean("active")->defaul(true);
            $table->longText("join_url");
            $table->longText("meta");
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
        Schema::dropIfExists('program_student_attendances');
    }
};
