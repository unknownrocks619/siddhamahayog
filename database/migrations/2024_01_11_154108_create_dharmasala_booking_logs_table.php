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
        Schema::create('dharmasala_booking_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('booking_id')->index();
            $table->longText('original_content')->nullable();
            $table->longText('changed_content')->nullable();
            $table->string('type')->nullable()->default('booking_status')->comment('available option: booking_status');
            $table->string('original_type_value')->nullable();
            $table->string('change_type_value')->nullable();
            $table->string('updated_by');
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
        Schema::dropIfExists('dharmasala_booking_logs');
    }
};
