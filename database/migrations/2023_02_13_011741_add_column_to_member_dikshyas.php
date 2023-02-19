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
        Schema::table('member_dikshyas', function (Blueprint $table) {
            //
            $table->string('dikshya_type')->default('tulasi')->after('guru_name');
            $table->string('ceromony_location')->after('dikshya_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_dikshyas', function (Blueprint $table) {
            //
            $table->dropColumn('dikshya_type');
            $table->dropColumn('ceomony_location');
        });
    }
};
