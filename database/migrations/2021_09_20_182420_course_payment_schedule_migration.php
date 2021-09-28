<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CoursePaymentScheduleMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("course_payment_schedules", function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id')->index();
            $table->string("sibir_record_id")->index();
            $table->string("last_payment_date");
            $table->string('next_payment_date');
            $table->string('number_of_notification');
            $table->string("last_transaction_amount");
            $table->string("is_used")->default(false)->index();
            $table->string("notification")->comment("available options: pause [payment made but not verified],stop[payment verified set next alert.]");
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
        //
    }
}
