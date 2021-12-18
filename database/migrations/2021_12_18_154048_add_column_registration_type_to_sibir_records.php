<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRegistrationTypeToSibirRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sibir_records', function (Blueprint $table) {
            //
            $table->string('registration_type')
                    ->nullable()
                    ->default('public')
                    ->comment("Available type:bod,admin,public,center,open");
            $table->string('sibir_type')
                    ->nullable()
                    ->default("education")
                    ->comment("Available option: education, agm, meeting, other");
            $table->string('additional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sibir_records', function (Blueprint $table) {
            //
        });
    }
}
