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
        Schema::create('lession_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lession_payments_id')->nullable()->constrained('lession_payments', 'id');
            $table->foreignId('program_chapter_lession_id')->nullable()->constrained('program_chapter_lessions', 'id');
            $table->foreignId('program_id')->nullable()->constrained('programs', 'id');
            $table->foreignId('program_course_id')->nullable()->constrained('program_courses', 'id');
            $table->foreignId('member_d')->constrained('members', 'id');
            $table->string('amount');
            $table->string('transaction_date');
            $table->integer('status')->default(1)->comment('available options: 1,2,3');
            $table->longText("settings")->nullable();
            $table->longText('remarks');
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
        Schema::dropIfExists('lession_payment_details');
    }
};
