<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserLogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_logins',function (Blueprint $table) {
            $table->id();
            $table->integer('user_detail_id')->comment('primary key from the table user_detail');
            $table->string('user_type',100)->nullable()->comment('determine which type of user e.g. Admin, User, Public, Guest');
            $table->string('email',100)->comment('user login through email');
            $table->text('password');
            $table->timestamp('verified')->nullable()->comment('check account verification status');
            $table->text('verification_link')->nullable()->comment('verification link');
            $table->enum('account_status',['Active','Hold','Unverified'])->comment('get account status');
            $table->integer('created_by_user')->nullable()->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment('only for soft delete');

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
        Schema::dropIfExists('user_logins');
    }
}
