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
        Schema::table('program_groupings', function (Blueprint $table) {
            //
            $table->boolean('is_scan')->default(false)->after('enable_auto_adding');
            $table->integer('group_type')->default(1)->after('is_scan')->comment('1: User Pass, 2: Volunteer, 3: Guest, 4: Other');
            $table->integer('default_photo')->nullable()->after('rules');
            $table->integer('scan_type')->default(0)->after('is_scan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_groupings', function (Blueprint $table) {
            //
            $table->dropColumn(['is_scan','group_type','default_photo','scan_type']);
        });
    }
};
