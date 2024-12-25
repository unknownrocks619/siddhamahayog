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
       $settings = new \App\Models\WebSetting();
       $insert = [
           ['name' => 'application','value' => 0,'description' => 'Enable Mobile Application Access'],
           ['name' => 'account_verification', 'value' => 0 ,'description' => 'Option to enable to disable account verification. (Phone & Email)'],
       ];

       $settings->insert($insert);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_settings', function (Blueprint $table) {
            //
        });
    }
};
