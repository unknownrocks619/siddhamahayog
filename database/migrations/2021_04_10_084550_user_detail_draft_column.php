<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserDetailDraftColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('user_details',function (Blueprint $table) {
            $table->boolean('draft')->default(false)->nullable();
            $table->text('address',500)->nullable()->comment('complete address');
            $table->text('place_of_birth',100)->nullable()->comment("user birth place");
            $table->text("emergency_contact",100)->nullable()->comment("emergency contact number");
            $table->string('relation_with_emergency_contact',100)->nullable();
            $table->string('emeregency_contact_name',100)->nullable();
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
