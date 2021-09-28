<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSadhakUniqueZoomRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sadhak_unique_zoom_registrations', function (Blueprint $table) {
            $table->id();
            $table->string("video_log_id")->nullable()->index();
            $table->text('join_link')->nullable();
            $table->string('user_detail_id')->nullable()->index();
            $table->boolean('have_joined')->default(false);
            $table->string('joined_at')->nullable();
            $table->string("sibir_record_id")->index();
            $table->string("meeting_id")->nullable();
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
        Schema::dropIfExists('sadhak_unique_zoom_registrations');
    }
}
