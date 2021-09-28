<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BookingClearance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("booking_clearances",function (Blueprint $table) {
            $table->id()->comment('Primary Key for Table');
            $table->string('bookings_id',11)->comment("Foreign Key, Reference from table booking.");
            $table->string('booking_code',100)->nullable()->comment("Foreign Key, Reference from table booking.booking_code");
            $table->text('remarks')->nullable();
            $table->integer('created_by_user')->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment("Only for soft deletes.");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('booking_clearances');
    }
}
