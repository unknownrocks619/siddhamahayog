<?php

namespace App\Classes\Helpers;

use App\Models\NavigationItem;
use App\Models\NavigationPosition;
use App\Models\Role;

class Navigation
{
    public static function adminParentAsideNavigationItems() {

        if ( session()->has('ADMIN_'.auth()->id().'_PARENT_ASIDE_NAVIGATION') ) {
            return session()->get('ADMIN_'.auth()->id().'_PARENT_ASIDE_NAVIGATION');
        }

        $navigations = NavigationPosition::where('nav_position','aside')->get();

        $permission = [];
        foreach ($navigations as $navigation) {
            if ( ! in_array('*',$navigation->permission) && ! in_array(auth()->user()->role_id,$navigation->permission) && (int) auth()->user()->role_id !== Role::SUPER_ADMIN) {
                continue;
            }

            $permission[] =  $navigation;
        }

        $items = [];

        foreach ($permission as $nav_items) {

            if  ( ! $nav_items->navigationItems->count() ) {
                continue;
            }

            foreach ($nav_items->navigationItems as $nav) {

                if ( ! in_array('*',$nav->permission) && !in_array(auth()->user()->role_id, $nav->permission) && (int) auth()->user()->role_id !== Role::SUPER_ADMIN) {
                    continue;
                }

                $items[] = $nav;
            }
        }
        session()->put('ADMIN_'.auth()->id().'_PARENT_ASIDE_NAVIGATION',$items);
        return session()->get('ADMIN_'.auth()->id().'_PARENT_ASIDE_NAVIGATION');
    }

}
