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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string("widget_name");
            $table->string("slug")->nullable();
            $table->longText("description")->nullable();
            $table->string("widget_type")->default("text")->comment("Available options: Slider, Accordian, Banner Text, FAQ, Button, PDF Reader, Carousel Slider, Video, Quote,Column wih Icon, Column, Banner Video, Banner Video Checkmark, Image");
            $table->longText("fields")->nullable();
            $table->longText("settings")->nullable();
            $table->longText("layouts")->nullable();
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
        Schema::dropIfExists('widgets');
    }
};
