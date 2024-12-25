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
        Schema::table('member_verifications', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('member_id')->nullable()->change();
            $table->string('validation_name')->nullable()->after('member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_verifications', function (Blueprint $table) {
            //
        });
    }
};
