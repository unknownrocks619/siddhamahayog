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
        Schema::create('member_to_sadhaks', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->index();
            $table->text('join_link');
            $table->longText('joinHistory')->nullable();
            $table->string('join_type')->default('sadhak');
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
        Schema::dropIfExists('member_to_sadhaks');
    }
};
