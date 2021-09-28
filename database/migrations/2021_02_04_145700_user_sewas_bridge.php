<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSewasBridge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_sewa_bridges',function (Blueprint $table) {
            $table->id();
            $table->string('user_id',10)->comment('Foreign key, Reference from table user_detail');
            $table->string('user_sewas_id',10)->comment('Foreign key, Reference from table user_sewas');
            $table->string('user_involvement',100)->default('sewa')->comment('differenciate what user did, i.e. user can have multiple sewa but what sewa did he provide. type: sewa_interested , sewa_involved');
            $table->integer('created_by_user')->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
            $table->string('bookings_id',10)->nullable()->comment("Making user enrolement in different sewas per visit."); 
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment("only for soft deletes.");
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
        Schema::dropIfExists('user_sewas_bridges');
    }
}
