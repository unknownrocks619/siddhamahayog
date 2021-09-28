<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_medias',function (Blueprint $table) {
            $table->id();
            $table->integer('created_by_user')->comment("Foreign Key, Reference from table user_login, in order to track authorized personal");
            $table->integer('user_detail_id')->comment('Foreign Key, Reference from table user_detail');
            $table->text('image_property');
            $table->text('image_url');
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('user_medias');
    }
}
