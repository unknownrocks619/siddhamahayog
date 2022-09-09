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
        //
        Schema::table("members", function (Blueprint $table) {
            // $table->integer("country")->nullable();
            // $table->integer("city")->nullable();
            // $table->longText("address")->nullable();
            // $table->foreignId("country")->nullable()->default(153);
            // $table->foreignId("city")->nullable()->default(2566);
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
};
