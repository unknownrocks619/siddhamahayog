<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SibirRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("sibir_records",function (Blueprint $table) {
            $table->id();
            $table->string('sibir_title',100)->nullable()->comment('title for the sibir');
            $table->string("sibir_duration")->nullable()->comment("Total duration this event will run, but null or 0 means no limitation");
            $table->string('total_capacity')->default(0)->comment('0 means unlimited capacity while centers may still have their own limitation.');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->boolean('active')->default(true)->comment("default status just in case");
            $table->string('slug');
            $table->integer('user_detail_id')->nullable()->comment("Foreign Key, Reference from table user_detail, in order to track authorized personal");
            $table->integer('user_login_id')->nullable()->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists("sibir_records");
    }
}
