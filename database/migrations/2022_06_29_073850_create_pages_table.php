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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string("page_name");
            $table->string('slug')->nullable();
            $table->longText("excerpt")->nullable();
            $table->longText("description")->nullable();
            $table->string("page_type")->default("standard")->comment("Available Options: home,policy,standard,gallery,video,contact");
            $table->string("display")->default('public')->comment("Available Options: Public, Autheticated, Admin, Parent, Teacher, Organisation, Student Unde, Student Above");
            $table->longText("image")->nullable();
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
        Schema::dropIfExists('pages');
    }
};
