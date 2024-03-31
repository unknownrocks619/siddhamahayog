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
            $table->string('actual_print_width')->after('rules');
            $table->string('actual_print_height')->after('actual_print_width');

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
            $table->dropColumn(['actual_print_width','actual_print_height']);
        });
    }
};
