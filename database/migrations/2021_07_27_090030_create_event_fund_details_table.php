<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFundDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_fund_details', function (Blueprint $table) {
            $table->id();
            $table->string('event_fund_id');
            $table->string('sibir_record_id');
            $table->string('user_detail_id');
            $table->string('user_login_id')->nullable();
            $table->string('amount');
            $table->string('source')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('owner_remarks')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->default('pending');
            $table->string("admin_remarks")->nullable();
            $table->string('status_changed')->nullable();
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
        Schema::dropIfExists('event_fund_details');
    }
}
