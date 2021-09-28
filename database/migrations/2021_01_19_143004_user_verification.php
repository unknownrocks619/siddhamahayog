<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserVerification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_verifications',function (Blueprint $table) {
            $table->id();
            $table->integer('user_detail_id')->comment('Foreign Key, reference to table user_detail');
            $table->string('verification_type',100);
            $table->text('document_file_detail');
            $table->integer('parent_id')->nullable()->comment('Foreign Key, Just in case if parent was already here.');
            $table->string('parent_name',100)->nullable();
            $table->string('parent_phone',100)->nullable();
            $table->boolean('verified')->defalut(true)->comment('for verification status');
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
        Schema::dropIfExists('user_verifications');
    }
}
