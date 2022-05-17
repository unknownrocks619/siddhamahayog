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
        Schema::create('program_course_fees', function (Blueprint $table) {
            $table->id();
            $table->string("program_id");
            $table->string("admission_fee");
            $table->string("monthly_fee");
            $table->boolean('online')->default(true);
            $table->boolean('offline')->default(true);
            $table->boolean("active")->boolean(true);
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
        Schema::dropIfExists('program_course_fees');
    }
};
