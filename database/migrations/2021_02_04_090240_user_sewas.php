<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSewas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_sewas',function (Blueprint $table) {
            $table->id()->comment('primary key for table.');
            $table->string('slug',100)->comment('slug id for sewas');
            $table->string('sewa_name',100)->comment('name of the sewa');
            $table->text('description')->nullable();
            $table->integer('created_by_user')->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment('only for soft delets.');
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
        Schema::dropIfExists('user_sewas');
    }
}
