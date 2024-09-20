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
        Schema::create('user_sadhana_levels_usl', function (Blueprint $table) {
            $table->id('id_usl');
            $table->unsignedBigInteger('user_id');
            $table->integer('charan_usl')->default(0);
            $table->integer('upacharan_usl')->default(1);
            $table->date('charan_date_usl')->nullable();
            $table->date('upacharan_date_usl')->nullable();
            $table->unsignedBigInteger('created_by_usl')->nullable();
            $table->timestamp('created_at_usl');
            $table->timestamp('updated_at_usl');
            $table->softDeletes('deleted_at_usl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sadhana_levels_usl');
    }
};
