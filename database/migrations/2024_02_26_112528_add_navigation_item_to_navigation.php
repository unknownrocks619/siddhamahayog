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

        Schema::table('navigation_items', function (Blueprint $table) {
            //
            $navPosition = \App\Models\NavigationPosition::where('nav_position','aside')->first();

            $navigationItems = new \App\Models\NavigationItem();
            $navigationItems->fill([
                'id_position' => $navPosition->getKey(),
                'icon'  => '',
                'name'  => 'Request',
                'order' => (\App\Models\NavigationItem::select('order')->whereNull('parent_id')->orWhere('parent_id',0)->max('order')) + 1,
                'permission'    => ['1','13'],
                'route' => 'admin.permission-request.list'
            ]);

            $navigationItems->save();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('navigation_items', function (Blueprint $table) {
            //
        });
    }
};
