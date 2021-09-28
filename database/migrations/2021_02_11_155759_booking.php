<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Booking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bookings',function ( $table ) {
            $table->id()->comment("primary key for the table.");
            $table->string('user_detail_id',11)->comment("Foreign Key, Table reference user_detail");
            $table->string('rooms_id')->comment("Foreign Key, table reference rooms");
            $table->string('check_in_date')->comment("User Check in Date");
            $table->string("check_out_date")->nullable()->comment("User Checked Out Date.");
            $table->boolean('is_occupied')->nullable()->comment('is if room is occupied');
            $table->string("booking_code",20)->nullable()->comment("unique booking reference no.");
            $table->string('status',100)->nullable()->comment('Only applicable if room will be prebooked. accepected values are. reserved');
            $table->boolean('is_reserved')->nullable()->comment('if this room is reserved');
            $table->string("remarks")->nullable()->comment("User Remarks (Option), When user check out of the system.");
            $table->string("total_duration",10)->nullable()->comment('Store total duration of stay.');
            $table->string('created_by_user',10)->comment('Track log for operator, Foreign Key Reference user_detail');
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
        Schema::dropIfExists('bookings');
    }
}
