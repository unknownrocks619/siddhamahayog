<?php

namespace App\Classes\Helpers;

use App\Models\NavigationItem;
use App\Models\NavigationPosition;
use App\Models\Role;

class Navigation
{
    public static function adminParentAsideNavigationItems() {

        if ( cache()->has('ADMIN_'.auth()->guard('admin')->id().'_PARENT_ASIDE_NAVIGATION') ) {
            // return cache()->get('ADMIN_'.auth()->guard('admin')->id().'_PARENT_ASIDE_NAVIGATION');
        }

        $navigations = NavigationPosition::where('nav_position','aside')->get();

        $permission = [];
        $currentUserRole = auth()->guard('admin')->user();

        foreach ($navigations as $navigation) {
            if ( ! in_array('*',$navigation->permission) &&
                 ! in_array($currentUserRole->role_id,$navigation->permission) 
                 && ! $currentUserRole->isSuperAdmin()) {
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

                if ( ! in_array('*',$nav->permission) 
                    && !in_array($currentUserRole->role_id, $nav->permission) && 
                    ! $currentUserRole->isSuperAdmin()) {
                    continue;
                }

                $items[] = $nav;
            }
        }

        session()->put('ADMIN_'.auth()->id().'_'.auth()->guard('admin')->user()->role_id.'_PARENT_ASIDE_NAVIGATION',$items);
        return session()->get('ADMIN_'.auth()->id().'_'.auth()->guard('admin')->user()->role_id.'_PARENT_ASIDE_NAVIGATION');
    }

}
