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
            $table->boolean('verified')->default(false)->after('member_id_card');
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
            $table->dropColumn(['verified']);
        });
    }
};
