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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('members', 'id');
            $table->foreignId('program_id')->constrained('programs', 'id');
            $table->string('scholar_type')->default("full")->comment('Full, Half, Void, VIP');
            $table->longText('remarks')->nullable();
            $table->longText('documents')->nullable();
            $table->boolean('active')->default(true);
            $table->string('created_by_user')->nullable();
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
        Schema::dropIfExists('scholar_ships');
    }
};
