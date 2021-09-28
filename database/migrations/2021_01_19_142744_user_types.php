<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_types',function(Blueprint $table) {
            $table->id();
            $table->text('user_type',100)->comment('determine type of user');
            $table->timestamp('created_at')->useCurrent()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');
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
        Schema::dropIfExists('user_types');
    }
}
