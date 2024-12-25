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
        $memberParent = \App\Models\NavigationItem::where("name",'Members')->whereNull('parent_id')->first();
        $newNavigationItems = new \App\Models\NavigationItem();
        $newNavigationItems->fill([
            'id_position'   => 1,
            'parent_id' => $memberParent->getKey(),
            'icon'  => 'medal',
            'name'  => 'Teachers',
            'order' => 2,
            'permission'    => [\App\Models\Role::ADMIN,\App\Models\Role::SUPER_ADMIN,\App\Models\Role::CENTER,\App\Models\Role::CENTER_ADMIN],
            'route' => 'admin.members.teacher.index'
        ]);
        $newNavigationItems->save();

        $newNavigationItems = new \App\Models\NavigationItem();
        $newNavigationItems->fill([
            'id_position'   => 1,
            'parent_id' => null,
            'icon'  => 'settings',
            'name'  => 'Setting',
            'order' => \App\Models\NavigationItem::whereNull('parent_id')->max('order')  + 1,
            'permission'    => [\App\Models\Role::SUPER_ADMIN,\App\Models\Role::ADMIN],
            'route' => 'admin.settings.index'
        ]);
        $newNavigationItems->save();
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
