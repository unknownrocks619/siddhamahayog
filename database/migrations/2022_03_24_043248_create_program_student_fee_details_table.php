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
        Schema::create('program_student_fee_details', function (Blueprint $table) {
            $table->id();
            $table->string("program_id");
            $table->string("student_id");
            $table->string("program_student_fees_id");
            $table->string('amount')->default(0);
            $table->string("amount_category")->nullable()->comment("Available options: donation, monthly fee, admission fee, others");
            $table->string('source')->default("cash deposit")->comment("available options: Cash Deposit, Cash Receipt, Cheque Deposit, Online");
            $table->string('source_detail')->nullable()->comment("For Cash and cheque deposit write Bank name and for online online transaction party name eg. esewa");
            $table->boolean('verified')->default(false)->comment('true verified and false or null unverified');
            $table->boolean("rejected")->default(false);
            $table->string("file")->nullable();
            $table->text("remarks")->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('program_student_fee_details');
    }
};
