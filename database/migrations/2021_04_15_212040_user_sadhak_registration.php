<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSadhakRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("user_sadhak_registrations",function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id');
            $table->string('is_active')->default(true);
            $table->string('branch_id')->nullable();
            $table->string('user_sadhak_registration_preference_id')->nullable();
            $table->string('sadhak_mental_qurie_id')->nullable();
            $table->string('sibir_record_id')->nullable();
            $table->boolean('is_new')->default(true);
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
    }
}
