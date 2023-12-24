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
        Schema::create('member_refers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id')->index();
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('relation')->nullable();
            $table->string('country')->nullable();
            $table->string('email_address')->nullable();
            $table->longText('remarks')->nullable();
            $table->string('status')->default('pending')->comment('available option: pending, follow-ups,cancelled,approved');
            $table->unsignedInteger('converted_id')->nullable()->index();
            $table->string('approved_date')->nullable();
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
        Schema::dropIfExists('member_refers');
    }
};
