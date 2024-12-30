<?php

use App\Classes\Helpers\Navigation;
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
        /**
         * Training & Courses
         */
        $parentNavigation = NavigationItem::where('name', 'Program & Settings')
            ->whereNull('parent_id')->first();

        $navigationItems = [
            'parent_id' => $parentNavigation->getKey(),
            'id_position'   => $parentNavigation->id_position,
            'icon'          => 'book',
            'name'  => 'Trainings',
            'order' => NavigationItem::where('parent_id', $parentNavigation->getKey())->count() + 1,
            'permission' => ['1', '13'],
            'route' => 'admin.trainings.index',
        ];
        $newChildNavigation = new NavigationItem($navigationItems);
        $newChildNavigation->save();

        // move staff inside member now.

        $staffNavigation = NavigationItem::where('name', 'Staffs')->first();
        $membersNavigation = NavigationItem::where('name', 'Members')->first();
        $staffNavigation->parent_id = $membersNavigation->getKey();
        $staffNavigation->icon = 'shield';
        $staffNavigation->order = NavigationItem::where('parent_id', $membersNavigation->getKey())->count() + 1;
        $staffNavigation->permission = [1, 13];
        $staffNavigation->save();

        // settings
        $settingNavigation = NavigationItem::where('name', 'Setting')->first();

        $miscNavigation = NavigationItem::where('name', 'Misc')->first();
        $noticeNavigation = NavigationItem::where('name', 'Notices')->first();
        $requestNavigation = NavigationItem::where('name', 'Request')->first();
        $centerNavigation = NavigationItem::where('name', 'Centers')->first();

        $centerNavigation->parent_id = $settingNavigation->getKey();
        $centerNavigation->icon = 'server';
        $centerNavigation->save();

        $requestNavigation->parent_id = $settingNavigation->getKey();
        $requestNavigation->order = NavigationItem::where('order', $settingNavigation->order)->count() + 1;
        $requestNavigation->icon = 'vector';
        $requestNavigation->save();

        $noticeNavigation->parent_id = $settingNavigation->getKey();
        $noticeNavigation->order = NavigationItem::where('order', $settingNavigation->order)->count() + 1;
        $noticeNavigation->icon = 'microphone';
        $noticeNavigation->save();

        $miscNavigation->parent_id = $settingNavigation->getKey();
        $miscNavigation->order = NavigationItem::where('order', $settingNavigation->order)->count() + 1;
        $miscNavigation->save();

        /**
         * Create new Navigation for Plugins
         */
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
