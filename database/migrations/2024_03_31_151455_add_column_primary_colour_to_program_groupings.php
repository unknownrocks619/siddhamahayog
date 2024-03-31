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
            $table->string('print_primary_colour')->after('id_parent');
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
            $table->dropColumn('print_primary_colour');
        });
    }
};
