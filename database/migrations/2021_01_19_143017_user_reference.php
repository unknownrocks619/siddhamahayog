<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_references',function (Blueprint $table) {
            $table->id();
            $table->integer('center_id')->nullable()->comment('if user was referred by any center');
            $table->integer('user_detail_id')->comment('Foreign Key, Reference from table user_detail');
            $table->string('name',100)->nullable();
            $table->string('phone_number',100)->nullable();
            $table->integer('created_by_user')->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
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
        Schema::dropIfExists('user_references');
    }
}
