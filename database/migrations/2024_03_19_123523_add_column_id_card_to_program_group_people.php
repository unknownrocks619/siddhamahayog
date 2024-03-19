<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_group_people', function (Blueprint $table) {
            //
            $table->string('member_id_card')->nullable()->after('profile_id');
            $table->string('generated_id_card')->nullable()->after('is_card_generated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_group_people', function (Blueprint $table) {
            //
            $table->dropColumn(['member_id_card','generated_id_card']);
        });
    }
};
