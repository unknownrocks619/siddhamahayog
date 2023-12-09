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
        Schema::create('hanumand_yagya_counters', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->index();
            $table->unsignedInteger('total_counter');
            $table->string('start_date')->nullable();
            $table->string('jap_type')->default('sumeru')->comment('Available Option: Sumeru, Mala, Mantra');
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
        Schema::dropIfExists('hanumand_yagya_counters');
    }
};
