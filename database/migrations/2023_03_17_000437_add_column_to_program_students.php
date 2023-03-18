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
        Schema::table('program_students', function (Blueprint $table) {
            //
            $table->boolean('allow_all')->default(false)->after('roll_number');
            $table->string('multiple_section')->nullable()->after('allow_all');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_students', function (Blueprint $table) {
            //
            $table->dropColumn(['allow_all', 'multiple_section']);
        });
    }
};
