<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Nights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('nights',function(Blueprint $table) {
            $table->id();
            $table->string('user_detail_id')->comment("Foreign Key, Reference from table user_detail");
            $table->string('nights',10)->nullable()->comment("Total Night spent by user");
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment('used for soft delete');
            $table->integer('created_by_user')->nullable()->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
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
        Schema::dropIfExists('nights');
    }
}
