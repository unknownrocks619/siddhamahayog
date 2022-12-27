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
        Schema::create('guest_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_id')->index();
            $table->foreignId("created_by_user")->constrained('members', 'id');
            $table->foreignId('program_id')->nullable()->constrained('programs', 'id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->longText('remarks')->nullable();
            $table->boolean('used')->default(false);
            $table->longText('access_detail')->nullable();
            $table->string('access_code');
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
        Schema::dropIfExists('guest_accesses');
    }
};
