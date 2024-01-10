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
        $darhmashalaMenus = [
            [
                'name' => 'Dharmashala',
                'route' => '',
                'icon'  => 'building',
                'permission'    => [\App\Models\Role::SUPER_ADMIN,\App\Models\Role::ADMIN,\App\Models\Role::DHARMASHALA],
                'order' => 5,
                'id_position' => 1,
                'children'  => [
                    [
                        'name'  => 'Buildings',
                        'route' => 'admin.dharmasala.building.list',
                        'icon'  => 'building',
                        'permission'    => ['*'],
                        'order' => 0,
                        'id_position'   => 1,
                    ],
                    [
                        'name'  => 'Rooms',
                        'route' => 'admin.dharmasala.rooms.list',
                        'icon'  => 'bed',
                        'permission'    => ["*"],
                        'order' => 1,
                        'id_position'   => 1,
                    ],
                    [
                        'name'  => 'Bookings',
                        'route' => 'admin.dharmasala.booking.list',
                        'icon'  => 'brand-booking',
                        'permission'    => ["*"],
                        'order' => 2,
                        'id_position'   => 1,
                    ],
                    [
                        'name'  => 'Amenities',
                        'route' => 'admin.dharmasala.amenities.list',
                        'icon'  => 'note',
                        'permission'    => ["*"],
                        'order' => 3,
                        'id_position'   => 1,
                    ],
                    [
                        'name'  => 'Online Bookings',
                        'route' => 'admin.dharmasala.online-booking.list',
                        'icon'  => 'brand-onlyfans',
                        'permission'    => ["*"],
                        'order' => 4,
                        'id_position'   => 1,
                    ],
                ]
            ]
        ];

        foreach ($darhmashalaMenus as $dharmasala) {
            $this->storeNavigationItem($dharmasala);
        }

    }
    private function storeNavigationItem(array $item,$parentID = null) {

        $navigationItem = new \App\Models\NavigationItem();

        if ($parentID) {
            $item['parent_id']  = $parentID;
        }

        $navigationItem->fill($item)->save();

        if ( isset ($item['children']) ) {
            foreach ($item['children'] as $item) {
                $this->storeNavigationItem($item,$navigationItem->getKey());
            }
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
