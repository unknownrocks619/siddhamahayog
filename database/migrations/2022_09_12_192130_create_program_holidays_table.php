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
        Schema::create('program_holidays', function (Blueprint $table) {
            $table->id();
            $table->foreignId("program_id")->constrained("programs", "id");
            $table->foreignId("student_id")->constrained("members", "id");
            $table->string("subject")->nullable();
            $table->longText("reason");
            $table->string("start_date");
            $table->string('end_date');
            $table->string('status')->default('pending')->comment("Available Options: pending, approved, rejected.");
            $table->longText('response_text')->nullable();
            $table->string('response_date')->nullable();
            $table->integer("response_by")->nullable();
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
        Schema::dropIfExists('program_holidays');
    }
};
