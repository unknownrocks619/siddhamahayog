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
        Schema::table('unpaid_accesses', function (Blueprint $table) {
            //
            $table->string('access_type')->after('total_joined')->default('attendance')->comment('available for: attendance, video access ,resources access');
            $table->string('relation_table')->after('access_type')->nullable();
            $table->string('relation_id')->after('relation_table')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unpaid_accesses', function (Blueprint $table) {
            //
            $table->dropColumn('access_type');
            $table->dropColumn('relation_table');
            $table->dropColumn('relation_id');
        });
    }
};
