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
        Schema::create('member_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("member_id")->constrained('members', "id")->nullable();
            $table->string("title");
            $table->string('slug');
            $table->longText("note")->nullable();
            $table->string("type")->default('draft')->nullable();
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
        Schema::dropIfExists('member_notes');
    }
};
