<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserReferenceUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('user_references',function (Blueprint $table) {
            $table->string('user_referer_id',10)->nullable()->comment("Foreign Key, Reference to table User Detail");
            $table->string('main_office',10)->nullable()->comment('if user preference has been registered in main office or is willing to get enroll in main office');
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
