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
        Schema::whenTableDoesntHaveColumn('members', 'birth_time', function (Blueprint $table) {
            $table->string('birth_time', 10)->nullable()->after('date_of_birth');
        });

        Schema::whenTableDoesntHaveColumn('members', 'father_name', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('phone_number');
            $table->string('mother_name')->nullable()->after('father_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::whenTableHasColumn('members', 'birth_time', function (Blueprint $table) {
            $table->dropColumn('birth_time');
        });

        Schema::whenTableHasColumn('members', 'father_name', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'mother_name']);
        });
    }
};
