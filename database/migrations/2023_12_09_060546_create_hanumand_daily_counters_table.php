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
        Schema::create('hanumand_daily_counters', function (Blueprint $table) {

            $table->id();
            $table->integer('humand_yagya_id')->index();
            $table->integer('member_id')->index();
            $table->string('count_date');
            $table->string('total_count');
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
        Schema::dropIfExists('hanumand_daily_counters');
    }
};
