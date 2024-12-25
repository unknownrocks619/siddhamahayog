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
        Schema::create('user_training_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('event_id');
            $table->string('course_group_name');
            $table->longText('course_description')->nullable();
            $table->string('course_end_date')->nullable();
            $table->string('course_duration')->nullable();
            $table->string('training_location')->nullable();
            $table->integer('course_status')->default(1)->comment('1: active, 2: inactive, 3: archieved.');
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_training_courses');
    }
};
