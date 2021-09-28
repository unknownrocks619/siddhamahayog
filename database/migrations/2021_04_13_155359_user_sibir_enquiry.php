<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSibirEnquiry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_sibir_tracks',function (Blueprint $table) {
            $table->id();
            $table->string('user_sibir_record_id',10)->comment('Foreign Key, Reference User Sibir Record');
            $table->boolean('continued')->default(true)->comment('After your last session have you continued your practiced ?
            ');
            $table->boolean('is_engaged')->default(true)->comment('Are you engaged in other sadhana sibir after your session in siddhamahayoga
            ');
            $table->string('daily_time')->nullable();
            $table->string('user_detail_id')->comment('Foreign Key, Reference user detail');
            // $table->boolean('');
            $table->timestamps();
            $table->timestamp("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
