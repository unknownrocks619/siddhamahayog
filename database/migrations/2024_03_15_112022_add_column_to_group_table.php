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
            $table->longText('id_card_print_width')->nullable()->after('id_card_sample');
            $table->longText('id_card_print_height')->nullable()->after('id_card_print_width');
            $table->longText('id_card_print_position_x')->nullable()->after('id_card_print_height');
            $table->longText('id_card_print_position_y')->nullable()->after('id_card_print_position_x');


            $table->boolean('enable_barcode')->default(false);
            $table->longText('barcode_print_width')->nullable()->after('id_card_print_position_y');
            $table->longText('barcode_print_height')->nullable()->after('barcode_print_width');
            $table->longText('barcode_print_position_x')->nullable()->after('barcode_print_height');
            $table->longText('barcode_print_position_y')->nullable()->after('barcode_print_position_x');
            
            $table->boolean('enable_personal_info')->default(false);
            $table->longText('personal_info_print_width')->nullable()->after('barcode_print_position_y');
            $table->longText('personal_info_print_height')->nullable()->after('personal_info_print_width');
            $table->longText('personal_info_print_position_x')->nullable()->after('personal_info_print_height');
            $table->longText('personal_info_print_position_y')->nullable()->after('personal_info_print_position_x');


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
            $table->dropColumn(['id_card_print_width',
            'id_card_print_height',
            'id_card_print_position_x',
            'id_card_print_position_y',
            'enable_barcode',
            'barcode_print_width',
            'barcode_print_height',
            'barcode_print_position_x',
            'barcode_print_position_y',
            'enable_personal_info',
            'personal_info_print_width',
            'personal_info_print_height',
            'personal_info_print_position_x',
            'personal_info_print_position_y',]);
        });
    }
};
