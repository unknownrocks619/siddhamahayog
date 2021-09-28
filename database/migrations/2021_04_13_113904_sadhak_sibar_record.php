<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SadhakSibarRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_sibir_records',function (Blueprint $table) {
            $table->id();
            $table->string('user_detail_id',10)->comment('Foreign key, Table User Detail');
            $table->string("branche_id",10)->nullable()->comment('Foreign Key, Table branches');
            $table->string("sibir_id",10)->nullable()->comment('Freign Key');
            $table->string("sibir_start_date_eng")->nullable();
            $table->string('sibir_start_date_nep')->nullable();
            $table->string("sibir_end_date_eng")->nullable();
            $table->integer("sibir_duration")->default(false);
            $table->boolean("verified")->default(false)->nullable()->comment('was this information verified');
            $table->string('verified_by')->nullable()->comment('Foreign Key, Reference table user_detail');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        Schema::dropIfExists('user_sibir_records');
    }
}
