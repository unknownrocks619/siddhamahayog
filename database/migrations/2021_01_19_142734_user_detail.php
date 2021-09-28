<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::defaultStringLength(191);

        Schema::create('user_details',function(Blueprint $table) {
            $table->id()->comment('primary key for the table');
            $table->string('first_name',100);
            $table->string('middle_name',100)->nullable();
            $table->string('last_name',100);
            $table->string('pet_name',100)->nullable();
            $table->string('date_of_birth_nepali',10);
            $table->string('date_of_birth_eng',30);
            $table->enum('gender',['male','female','other'])->default('male');
            $table->string('phone_number',16);
            $table->string('country',50);
            $table->string('city',50);
            $table->string('user_type',100)->comment('determine which type of user, eg. [Dikshit, Non Dikshit, world family], Assigned from Table USER_TYEPS');
            // $table->string('user_category',100)->comment('determine which type of user category, eg. [World Family, Dikshit, Non-Dikshit]');
            $table->string('user_room_allotment',100)->nullable()->comment('pre determine which room to allot when making entry');
            $table->string('education_level',100)->nullable()->comment('education level.');
            $table->string('profession',100)->nullable()->comment('profession');
            $table->string('skills',100)->nullable()->comment('skills');
            $table->enum('marritial_status',['Married','Unmarried','Other'])->comment('marritial status of visitors');
            $table->string('married_to_id',10)->nullable()->comment('get the id of the person from already entered info');
            $table->integer('profile_id')->nullable()->comment('which profile to display.');
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
        Schema::dropIfExists("user_details");
    }
}
