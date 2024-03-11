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
        Schema::table('member_emergency_metas', function (Blueprint $table) {
            //
            $table->string('gotra')->nullable()->after('contact_type');
            $table->boolean('confirmed_family')->default(false)->nullable()->after('gotra');
            $table->boolean('verified_family')->default(false)->nullable()->after('confirmed_family');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_emergency_metas', function (Blueprint $table) {
            //
            $table->dropColumn(['gotra','confirmed_family','verified_family']);
        });
    }
};
