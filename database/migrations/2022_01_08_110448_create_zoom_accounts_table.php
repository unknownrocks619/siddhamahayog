<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoom_accounts', function (Blueprint $table) {
            $table->id();
            $table->string("account_name")->comment("Account identification name");
            $table->string('slug')->comment("unique slug for name");
            $table->string("account_status")->comment("Account Status: active, inactive, suspend");
            $table->string("account_username")->comment("Actual Zoom Account Username");
            $table->longText("api_token")->comment("ZOOM Developer API Token");
            $table->string("category")->default("admin")->comment('meeting type: Zonal, Admin (All), Local, Other');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoom_accounts');
    }
}
