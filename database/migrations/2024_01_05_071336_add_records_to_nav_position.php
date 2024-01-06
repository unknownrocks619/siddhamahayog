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
        $navPosition = new \App\Models\NavigationPosition();
        $navPosition->fill([
            'nav_position' =>'aside',
            'permission'    => ['*']
        ]);

        $navPosition->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nav_position', function (Blueprint $table) {
            //
        });
    }
};
