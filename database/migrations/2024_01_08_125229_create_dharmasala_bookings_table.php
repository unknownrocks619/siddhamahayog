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
        Schema::create('dharmasala_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('building_id')->nullable()->index();
            $table->unsignedInteger('floor_id')->nullable()->index();
            $table->unsignedInteger('room_id')->index();
            $table->unsignedInteger('member_id')->index()->nullable();
            $table->string('room_number')->index();
            $table->string('building_name')->nullable();
            $table->string('floor_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('check_in')->nullable()->index();
            $table->string('check_out')->nullable()->index();
            $table->string('profile')->nullable();
            $table->string('id_card')->nullable();
            $table->integer('status')->default(1)->comment('1 : reserved, 2: In, 3 : Out, 4: Canceled, 5: booking, 6: processing, 7: Legacy');
            $table->uuid()->nullable()->index();
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
        Schema::dropIfExists('dharmasala_bookings');
    }
};
