<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DonationTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('donation_transactions',function (Blueprint $table) {
            $table->id();
            $table->integer('user_detail_id')->unsigned()->comment("Foreign Key, Reference to table user_detail");
            $table->string("source",100)->nullable()->comment('for users who makes donation out of courtisy');
            $table->string('donation_amount')->nullable()->comment("Donation Amount per person");
            $table->string('bookings_id')->nullable()->comment("If the donation user has stayed here.");
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment('used for soft delete');
            $table->integer('created_by_user')->nullable()->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
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
        Schema::dropIfExists('donation_transactions');
    }
}
