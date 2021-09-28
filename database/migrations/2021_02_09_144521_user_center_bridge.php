<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserCenterBridge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Schema::create('user_center_bridges',function (Blueprint $table) {
            // $table->id();
            // $table->string('user_details_id',10)->comment("Foreign Key, Reference to table user_details");
            // $table->string('centers_id',10)->comment('Foreign Key, Reference to table centers');
            // $table->string('')

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists();
    }
}
