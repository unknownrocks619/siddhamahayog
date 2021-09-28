<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFamilyGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('user_family_groups', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('sibir_record_id');
        //     $table->string('leader_id');
        //     $table->string('member_id');
        //     $table->boolean('status')->default(true);
        //     $table->string("relation");
        //     $table->string('approved')->default(false);
        //     $table->string('approved_by')->nullable();
        //     $table->string('user_sadhak_registration_id')->nullable();
        //     $table->string("link_type")->nullable()->comment("Either Email or Login ID (Phone)");
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_family_groups');
    }
}
