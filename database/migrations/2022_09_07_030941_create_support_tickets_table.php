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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("member_id")->constrained("members", "id");
            $table->integer("parent_id")->nullable();
            $table->string("category");
            $table->string("title");
            $table->string('priority')->default("low");
            $table->string("status")->default('pending')->comment("Available Options: pending, Completed, Rejected, Waiting Response, Replied");
            $table->longText("issue")->nullable();
            $table->longText("media")->nullable();
            $table->integer("total_count")->default(0)->nullable();
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
        Schema::dropIfExists('support_tickets');
    }
};
