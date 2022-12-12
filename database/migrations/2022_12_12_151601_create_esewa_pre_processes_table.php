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
        Schema::create('esewa_pre_processes', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->index();
            $table->string("pid", '150');
            $table->string('amount');
            $table->string('status')->default('started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('esewa_pre_processes');
    }
};
