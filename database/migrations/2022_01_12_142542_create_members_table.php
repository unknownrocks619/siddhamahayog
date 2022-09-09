<?php

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string("first_name");
            $table->string("middle_name")->nullable();
            $table->string('last_name')->nullable();
            $table->string("source")->default("portal")->comment('available options: facebook, gmail');
            $table->string("external_source_id")->nullable()->comment("If login using facebook and gmail use this to track their id.");
            $table->longText("profile")->nullable();
            $table->string('gender')->nullable();
            $table->integer("country")->nullable();
            $table->longText("city")->nullable();
            $table->longText('address')->nullable();
            $table->longText("date_of_birth")->nullable();
            $table->string('email')->unique()->nullable();
            $table->text("password");
            $table->string('phone_number')->nullable();
            $table->longText('profileUrl')->nullable()->comment("for social media login");
            $table->boolean("is_email_verified")->default(false);
            $table->boolean('is_phone_verified')->default(false);
            $table->string("role_id");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
