<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Branches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('branches',function (Blueprint $table) {

            $table->id();
            $table->string('name',100)->nullable()->comment('Just in case to refer with different name');
            $table->string('location')->nullable();
            $table->string('lat',50)->nullable()->comment('geo location of latitude');
            $table->string('lng',50)->nullable()->coment('geo location of longitutde');
            $table->string('geo_location',100)->nullable()->comment('full geo location');
            $table->text('iframe_location')->nullable()->comment("place an iframe of the map");
            $table->string('contact_person')->nullable();
            $table->string('person_phone')->nullable();
            $table->string('landline')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment('only for soft deletes.');
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
        Schema::dropIfExists("branches");
    }
}
