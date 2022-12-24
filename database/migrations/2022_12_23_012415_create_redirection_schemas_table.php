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
        Schema::create('redirection_schemas', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->index();
            $table->longText('views')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->default('correction');
            $table->string('modal')->nullable();
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
        Schema::dropIfExists('redirection_schemas');
    }
};
