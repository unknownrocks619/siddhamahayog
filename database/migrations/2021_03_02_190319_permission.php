<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Permission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('permissions',function (Blueprint $table){
            $table->id();
            $table->string('roles_id')->comment("Foreign Key, Associated with table roles");
            $table->boolean('read')->default(false)->comment("Is this role is allowed to read");
            $table->boolean('update')->default(false)->comment("Is this role is allowed to update");
            $table->boolean('delete')->default(false)->comment("Is this role is allowed to delete");
            $table->boolean('create')->default(false)->comment("Is this role is allowed to create");
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment("only for soft delete.");

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
        Schema::dropIfExists('permissions');
    }
}
