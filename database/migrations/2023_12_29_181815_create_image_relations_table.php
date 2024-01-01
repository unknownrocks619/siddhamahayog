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
        Schema::create('image_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('image_id')->index();
            $table->string('relation');
            $table->unsignedInteger('relation_id');
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->string('description');
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
        Schema::dropIfExists('image_relations');
    }
};
