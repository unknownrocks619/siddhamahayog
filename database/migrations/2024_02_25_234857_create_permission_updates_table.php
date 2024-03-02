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

        Schema::create('permission_updates', function (Blueprint $table) {
            $table->id();
            $table->string('relation_table');
            $table->string('relation_id');
            $table->string('request_type')->default('update')->comment('update, delete, create');
            $table->string('update_column')->nullable();
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->longText('row_old_value')->nullable();
            $table->longText('row_new_value')->nullable();
            $table->integer('status')->default(1)->comment('1: request sent, 2: Approved, 3: Rejected, 4: Waiting Modification')->index();
            $table->unsignedInteger('update_request_by_user')->index();
            $table->unsignedInteger('update_request_by_center')->index();
            $table->unsignedInteger('updated_by_user')->index();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_updates');
    }
};
