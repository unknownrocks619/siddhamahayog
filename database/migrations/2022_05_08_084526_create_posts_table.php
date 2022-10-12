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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string('slug');
            $table->longText("short_description")->nullable();
            $table->longText("full_description")->nullable();
            $table->longText("images")->nullable();
            $table->longText("videos")->nullable();
            $table->string("post_layout")->default('general')->comment("Available Options: Gallery, Contact, Video, General, Single Post, Posts, Team etc.");
            $table->string('post_type')->default("public")->comment("Available Options: public, autheticated, admin, student, teacher, org");
            $table->boolean("active")->default(true);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('posts');
    }
};
