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
        Schema::create('program_volunteers', function (Blueprint $table) {
            $table->id();
            $table->integer('program_id')->index();
            $table->integer('member_id')->index()->nullable();
            $table->integer('volunteer_group_id')->default(0);
            $table->string('full_name');
            $table->string('gotra')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('country')->nullable();
            $table->longText('full_address')->nullable();
            $table->string('education')->nullable();
            $table->string('gender')->nullable();
            $table->string('profession')->nullable();
            $table->boolean('involved_in_program')->nullable();
            $table->boolean('was_involved_in_volunteer')->nullable();
            $table->boolean('confirm_presence')->nullable();
            $table->boolean('accept_terms_and_conditions')->nullable();
            $table->boolean('accepted_as_volunteer')->nullable();
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
        Schema::dropIfExists('program_volunteers');
    }
};
