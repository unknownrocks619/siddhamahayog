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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->longText("title");
            $table->longText("notice")->nullable();
            $table->string("notice_type")->default("text")->comment("available options: text, file, video");
            $table->longText("settings")->nullable();
            $table->boolean("active")->default(true);
            $table->string('target')->default("all")->comment("available options: all, program");
            $table->foreignId("program_id")->nullable()->constrained("programs", "id");
            $table->foreignId("section_id")->nullable()->constrained('program_sections', 'id');
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
        Schema::dropIfExists('notices');
    }
};
