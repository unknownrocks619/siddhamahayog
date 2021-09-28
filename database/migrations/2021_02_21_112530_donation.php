<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Donation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("donations",function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id',11)->comment("Foreign Key, Reference from table user_detail");
            $table->string('amount',11)->default(false)->comment();
            $table->text("remark")->nullable()->comment();
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
        Schema::dropIfExists('donations');
    }
}
