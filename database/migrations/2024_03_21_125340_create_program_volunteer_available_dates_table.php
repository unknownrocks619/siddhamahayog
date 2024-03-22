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
        Schema::create('program_volunteer_available_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->nullable()->index();
            $table->integer('program_volunteer_id')->index();
            $table->string('available_dates');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('program_volunteer_available_dates');
    }
};
