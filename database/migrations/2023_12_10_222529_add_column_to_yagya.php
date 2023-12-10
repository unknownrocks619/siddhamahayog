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
        Schema::table('hanumand_yagya_counters', function (Blueprint $table) {
            //
            $table->boolean('is_taking_part')->after('total_counter')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hanumand_yagya_counters', function (Blueprint $table) {
            //
            $table->dropColumn('is_taking_part');
        });
    }
};
