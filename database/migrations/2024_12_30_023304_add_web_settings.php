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
        //
        $setting = \App\Models\NavigationItem::whereNull('parent_id')->where('name', 'Setting')->first();
        $webSetting = new \App\Models\NavigationItem([
            'parent_id' => $setting->getKey(),
            'id_position'   => $setting->id_position,
            'icon'          => 'settings',
            'name'  => 'Web Settings',
            'order' => \App\Models\NavigationItem::where('parent_id', $setting->getKey())->count() + 1,
            'permission' => [1, 13],
            'route' => 'admin.settings.index',
        ]);
        $webSetting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
