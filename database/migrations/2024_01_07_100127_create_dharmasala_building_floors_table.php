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
        Schema::create('dharmasala_building_floors', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('building_id')->index();
            $table->string('floor_name');
            $table->string('floor_prefix')->nullable();
            $table->string('total_rooms')->nullable();
            $table->string('status')->default('active');
            $table->boolean('online')->default(false);
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
        Schema::dropIfExists('dharmasala_building_floors');
    }
};
