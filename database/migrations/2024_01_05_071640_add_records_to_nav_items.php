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
        $navigationItems = [
            [
                'name' => 'Dashboard',
                'route' => 'admin.admin_dashboard',
                'icon'  => '',
                'order' => 0,
                'id_position' => 1,
                'permission'    => ['*']
            ],
            [
            'name' => 'Program & Settings',
            'route' => '',
            'icon'  => 'layout-sidebar',
            'order' => 1,
            'id_position' => 1,
            'permission'    => ['*'],
            'children'  => [
                    [
                        'name' => 'All Program',
                        'icon'  => 'menu-2',
                        'route' => 'admin.program.admin_program_list',
                        'order' => 0,
                        'id_position'   => 1,
                        'permission'    => ['*']
                    ],
                    [
                        'name'  => 'Live Program',
                        'icon'  => 'layout-distribute-vertical',
                        'route' => 'admin.program.all-live-program',
                        'id_position'   => 1,
                        'permission'    => ['*'],
                        'order' => 1
                    ],
                    [
                        'name'  => 'Zoom Settings',
                        'icon'  => 'layout-distribute-vertical',
                        'route' => '',
                        'order' => 2,
                        'id_position'   => 1,
                        'permission'    => ['*'],
                        'children'  => [
                            [
                                'name'  => 'Accounts',
                                'icon'  => 'admin.admin_zoom_account_show',
                                'route' => '',
                                'id_position'   => 1,
                                'permission'    => ['*'],
                                'order' => 0
                            ]
                        ]
                    ]

                ]
            ],
            [
                'name'  => 'Members',
                'route' => '',
                'icon'  => 'layout-grid-add',
                'order' => 2,
                'id_position'   => 1,
                'permission'    => ['*'],
                'children'  => [
                    [
                        'name' => 'All Members',
                        'icon'  => 'users',
                        'route' => 'admin.members.all',
                        'order' => 0,
                        'id_position'   => 1,
                        'permission'    => ['*']
                    ],
                    [
                        'name' => 'Sadhak List',
                        'icon'  => 'users',
                        'route' => '',
                        'order' => 1,
                        'id_position'   => 1,
                        'permission'    => ['*']
                    ],
                    [
                        'name' => 'Volunteers',
                        'icon'  => 'users',
                        'route' => '',
                        'order' => 2,
                        'id_position'   => 1,
                        'permission'    => ['*']
                    ],
                    [
                        'name' => 'Staffs',
                        'icon'  => 'users',
                        'route' => '',
                        'order' => 3,
                        'id_position'   => 1,
                        'permission'    => ['*']
                    ],


                ]
            ],
            [
                'name'  => 'Notices',
                'route' => 'admin.notices.notice.index',
                'icon'  => '',
                'order' => 3,
                'id_position'   => 1,
                'permission'    => ['*']
            ],
            [
                'name'  => 'Misc',
                'route' => '',
                'icon'  => 'box-multiple',
                'order' => 4,
                'id_position'   => 1,
                'permission'    => ['*'],
                'children'  => [
                    [
                        'name' => 'Support',
                        'icon'  => 'lifebuoy',
                        'route' => '',
                        'order' => 0,
                        'id_position'   => 1,
                        'permission'    => ['*'],
                        'children'  => [
                                [
                                    'name' => 'Support',
                                    'icon'  => 'lifebuoy',
                                    'route' => '',
                                    'order' => 0,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                    'children'  => [
                                    ]
                                ],
                                [
                                    'name' => 'Notice',
                                    'icon'  => 'lifebuoy',
                                    'route' => 'admin.supports.tickets.list',
                                    'order' => 0,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                ],
                                [
                                    'name' => 'High Priority',
                                    'icon'  => 'lifebuoy',
                                    'route' => 'admin.supports.tickets.list',
                                    'route_params'  => ['type' =>'priority','filter' => 'high'],
                                    'order' => 1,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                ],
                                [
                                    'name' => 'Medium Priority',
                                    'icon'  => 'lifebuoy',
                                    'route' => 'admin.supports.tickets.list',
                                    'route_params'  => ['type' =>'priority','filter' => 'medium'],
                                    'order' => 2,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                ],
                                [
                                    'name' => 'Low Priority',
                                    'icon'  => 'lifebuoy',
                                    'route' => 'admin.supports.tickets.list',
                                    'route_params'  => ['type' =>'priority','filter' => 'low'],
                                    'order' => 3,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                ],
                                [
                                    'name' => 'Finance Category',
                                    'icon'  => 'lifebuoy',
                                    'route' => 'admin.supports.tickets.list',
                                    'route_params'  => ['type' =>'category','filter' => 'finance'],
                                    'order' => 4,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                ],
                                [
                                    'name' => 'Technical Category',
                                    'icon'  => 'lifebuoy',
                                    'route' => 'admin.supports.tickets.list',
                                    'route_params'  => ['type' =>'category','filter' => 'technical_support'],
                                    'order' => 5,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                ],
                                [
                                    'name' => 'Admission Category',
                                    'icon'  => 'lifebuoy',
                                    'route' => 'admin.supports.tickets.list',
                                    'route_params'  => ['type' =>'category','filter' => 'admission'],
                                    'order' => 6,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                ],
                                [
                                    'name' => 'Other Category',
                                    'icon'  => 'lifebuoy',
                                    'route' => 'admin.supports.tickets.list',
                                    'route_params'  => ['type' =>'category','filter' => 'other'],
                                    'order' => 7,
                                    'id_position'   => 1,
                                    'permission'    => ['*'],
                                ],
                            ]
                         ],
                ]
            ]
        ];


        foreach ($navigationItems as $navItems) {
            $this->storeNavigationItem($navItems);
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
        Schema::table('nav_items', function (Blueprint $table) {
            //
        });
    }
};
