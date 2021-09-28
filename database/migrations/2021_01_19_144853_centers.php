<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Centers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("centers",function (Blueprint $table) {

            $table->id();
            $table->string('center_name',100);
            $table->string('country',100);
            $table->string('city',100);
            $table->string('street_address',100);
            $table->string('geo_location_lat',100);
            $table->string('geo_location_lng',100);
            $table->string('geo_location',100);
            $table->timestamps();
            $table->timestamp("deleted_at")->nullable();
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
        Schema::dropIfExists('centers');
    }
}
