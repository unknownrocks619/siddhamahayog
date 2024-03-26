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
        Schema::table('program_group_people', function (Blueprint $table) {
            //
            $table->string('resized_image')->nullable()->after('generated_id_card');
            $table->string('barcode_image')->nullable()->after('resized_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_group_people', function (Blueprint $table) {
            //
            $table->dropColumn(['resized_image','barcode_image']);
        });
    }
};
