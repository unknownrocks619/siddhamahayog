<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserCenterPreference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_sadhana_registration_preference',function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id',10)->comment('foreign key, Table user detail');
            $table->string('center_id',10)->nullable()->comment('foreign key, Table Center');
            $table->string('reference_type')->nullable()->comment('preference');
            $table->boolean('confirmed')->default(false)->nullable()->comment('if user selected center was confirmed mark true');
            $table->boolean('verified')->defualt(false)->comment('after registration only verified users are allowed to enter.');
            $table->boolean('cancelled')->default(false)->nullable()->comment('if user selected center was cancelled mark true');
            $table->boolean('pending')->default(true)->nullable()->comment('if admin or staff is yet to verify submission.');
            $table->boolean('completed')->default(false)->nullable()->comment("Only if the sibir period is over.");
            $table->string('status_updated_by')->nullable()->comment('track who last updated the table information');
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
        Schema::dorpIfExist('user_center_preferences');
    }
}
