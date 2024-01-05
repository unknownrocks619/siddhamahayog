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
                'route' => '',
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
            'permission'    => ['*']
            ],
            [
                'name'  => 'Members',
                'route' => '',
                'icon'  => 'layout-grid-add',
                'order' => 2,
                'id_position'   => 1,
                'permission'    => ['*']
            ],
            [
                'name'  => 'Notices',
                'route' => 'admin.notices.notice.index',
                'icon'  => '',
                'order' => 3,
                'id_position'   => ['*']
            ]
        ];
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
