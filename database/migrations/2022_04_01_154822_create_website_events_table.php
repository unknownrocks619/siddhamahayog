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
        Schema::create('website_events', function (Blueprint $table) {
            $table->id();
            $table->string('program')->nullable();
            $table->string('event_title');
            $table->string('slug')->nullable();
            $table->string("event_type")->nullable()->default('online')->comment("online, offline, live");
            $table->longText('full_description')->nullable();
            $table->longText("short_description")->nullable();
            $table->text('featured_image')->nullable();
            $table->text("page_image")->nullable();
            $table->string("event_start_date")->nullable();
            $table->string("event_start_time")->nullable();
            $table->string("event_end_date")->nullable();
            $table->string('event_end_time')->nullable();
            $table->string('event_contact_person')->nullable();
            $table->string('event_contact_phone')->nullable();
            $table->string('full_address')->nullable();
            $table->string('google_map_link')->nullable();
            $table->string("status")->default("upcoming")->comment('available options: upcoming,Ongoing,completed, pending');
            $table->boolean('completed')->default(false)->nullable();
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
        Schema::dropIfExists('website_events');
    }
};
