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
        Schema::create('member_emergency_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("member_id")->constrained("members", "id");
            $table->longText('contact_person');
            $table->string("relation");
            $table->string("email_address")->nullable();
            $table->string("phone_number");
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
        Schema::dropIfExists('member_emergency_metas');
    }
};
