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
        Schema::create('program_group_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->index();
            $table->unsignedBigInteger('program_id')->index();
            $table->unsignedBigInteger('group_id')->index();
            $table->boolean('is_parent')->nullable()->default(0);
            $table->string('dharmasala_booking_id')->nullable();
            $table->string('dharmasala-uuid')->nullable();
            $table->longText('access_permission')->nullable();
            $table->integer('order')->nullable();
            $table->string('colour');
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
        Schema::dropIfExists('program_group_people');
    }
};
