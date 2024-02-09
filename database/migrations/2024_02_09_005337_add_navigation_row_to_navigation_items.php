<?php

use App\Models\NavigationItem;
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
            /** Staffs */

            $parentNavigation = new NavigationItem();
            
            $parentNavigation->fill([
                'id_position' => 1,
                'parent_id' => null,
                'icon'  => 'box-users',
                'name'  => 'Staffs',
                'order' => (NavigationItem::whereNull('parent_id')->max('order')) + 1,
                'permission'    => [1,13],
                'route' => '',
                'route_params'  => null
            ]);
            $parentNavigation->save();

            $childrens = [
                [
                    'parent_id' => $parentNavigation->getKey(),
                    'icon'  => '',
                    'name'  => 'List',
                    'id_position' => $parentNavigation->id_position,
                    'permission'    => [1,13],
                    'route' => 'admin.users.list',
                    'order' => 0
                ],
                [
                    'parent_id' => $parentNavigation->getKey(),
                    'icon'  => '',
                    'name'  => 'Add New Staff',
                    'id_position' => $parentNavigation->id_position,
                    'permission'    => [1,13],
                    'route' => 'admin.users.create',
                    'order' => 1
                ],
            ];

            foreach ($childrens as $centerChildren) {
                $navigation = new NavigationItem();
                $navigation->fill($centerChildren);
                $navigation->save();
            }
            /**
             * Centers
             */
            
             $parentNavigation = new NavigationItem();
            $parentNavigation->fill([
                'id_position' => 1,
                'parent_id' => null,
                'icon'  => '',
                'name'  => 'Centers',
                'order' => (NavigationItem::whereNull('parent_id')->max('order')) + 1,
                'permission'    => [1,13],
                'route' => '',
                'route_params'  => null
            ]);
            $parentNavigation->save();

            $childrens = [
                [
                    'parent_id' => $parentNavigation->getKey(),
                    'icon'  => '',
                    'name'  => 'List',
                    'id_position' => $parentNavigation->id_position,
                    'permission'    => [1,13],
                    'route' => 'admin.centers.list',
                    'order' => 0
                ],
                [
                    'parent_id' => $parentNavigation->getKey(),
                    'icon'  => '',
                    'name'  => 'New Center',
                    'id_position' => $parentNavigation->id_position,
                    'permission'    => [1,13],
                    'route' => 'admin.centers.create',
                    'order' => 1
                ],
            ];
            
            foreach ($childrens as $centerChildren) {
                $navigation = new NavigationItem();
                $navigation->fill($centerChildren);
                $navigation->save();
            }
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
