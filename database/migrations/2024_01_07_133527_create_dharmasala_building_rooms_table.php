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
        Schema::create('dharmasala_building_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->index();
            $table->unsignedInteger('building_id')->index()->nullable();
            $table->unsignedInteger('floor_id')->index()->nullable();
            $table->integer('room_capacity')->nullable();
            $table->string('room_name')->nullable();
            $table->longText('room_description');
            $table->string('room_prefix')->nullable();
            $table->string('searchable_room')->nullable();
            $table->string('room_type')->default('single')->comment('available options: single, twin, double, hall, open');
            $table->longText('amenities')->nullable();
            $table->string('room_category')->default('general')->comment('available type: general, reserved,vip,paid');
            $table->boolean('is_available')->default(true);
            $table->boolean('online')->default(true);
            $table->boolean('enable_booking')->default(false);
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
        Schema::dropIfExists('dharmasala_building_rooms');
    }
};
