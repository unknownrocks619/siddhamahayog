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
        $zoomAccountParent = \App\Models\NavigationItem::where('name','Zoom Settings')
                                                        ->first();
        $childNavigation = \App\Models\NavigationItem::where('name','Accounts')
                                                        ->where('parent_id',$zoomAccountParent->getKey())
                                                        ->first();
        if ($childNavigation ) {
            $childNavigation->route = 'admin.zoom.admin_zoom_account_show';
            $childNavigation->save();
        }

        $memberParent = \App\Models\NavigationItem::where("name",'Members')->whereNull('parent_id')->first();
        $newNavigationItems = new \App\Models\NavigationItem();
        $newNavigationItems->fill([
            'id_position'   => 1,
            'parent_id' => $memberParent->getKey(),
            'icon'  => 'network',
            'name'  => 'Mobile',
            'order' => 1,
            'permission'    => [1,13,2,9],
            'route' => 'admin.settings.admin_website_settings'
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
