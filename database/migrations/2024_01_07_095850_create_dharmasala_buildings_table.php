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
        Schema::create('dharmasala_buildings', function (Blueprint $table) {
            $table->id();
            $table->string('building_name');
            $table->string('no_of_floors');
            $table->string('building_location')->nullable();
            $table->string('building_color')->nullable();
            $table->string('building_category')->default('general')->comment('can be used to distinguished for VIP building');
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
        Schema::dropIfExists('dharmasala_buildings');
    }
};
