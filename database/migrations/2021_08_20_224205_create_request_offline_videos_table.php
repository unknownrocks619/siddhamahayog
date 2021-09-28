<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestOfflineVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('request_offline_videos', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('user_detail_id')->index();
        //     $table->string('sibir_record_id')->nullable()->index();
        //     $table->string('offline_video_id')->nullable()->index();
        //     $table->string('status')->default('pending')->comment('available options: pending, approved, cancelled');
        //     $table->boolean('approved')->defualt(false);
        //     $table->string('approved_by')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_offline_videos');
    }
}
