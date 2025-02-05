<?php

use App\Models\AdminUser;
use App\Models\Menu;
use App\Models\Program;
use App\Models\Slider;
use App\Models\SliderSetting;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if (!function_exists("site_settings")) {

    function site_settings($key = null)
    {

        $settings = Cache::get("web_settings");
        if ( ! $settings || $_ENV['APP_ENV'] != 'production') {
            $settings = \App\Models\WebSetting::get();
        }


        return ($key && $settings->where("name", $key)->first()) ? $settings->where('name', $key)->first()->value : null;
    }
}

if (!function_exists("menus")) {

    function menus($search = [])
    {
        $cache = true;
        if (!site_settings("cache")) {
            $cache = true;
        }

        if ($cache) {
            $menus = Cache::get("menus");
        } else {
            if ($search) {
                $menus = Menu::where($search)->get();
            } else {
                $menus = Menu::get();
            }
        }

        return $menus;
    }
}

if (!function_exists('programs')) {

    function programs($types = null)
    {
        if (Cache::has('programs')) {
            $all_programs = Cache::get('programs')->where('status', 'active');
        } else {
            $all_programs = Program::where('status', 'active')->get();
        }

        if ($types) {
            return $all_programs->where('program_type', $types);
        }

        return $all_programs;
    }
}


if (!function_exists("plugins_slider")) {

    function plugins_slider()
    {


        if (Cache::has("slider_settings")) {
            return Cache::get('slider_settings');
        } else {
            return Slider::latest()->get();
        }
    }
}

if (!function_exists("cache_website")) {

    function cache_website($cache_name, $cache)
    {
        $cache_names = [
            "web_settings",
            "menus",
            "page_settings",
            "post_settings",
            "event_settings",
            "slider_settings"
        ];

        Cache::put($cache_name, $cache);
    }
}


if (!function_exists("event_status")) {

    function event_status($start_date, $end_date = null)
    {

        if (!$end_date) {
            $end_date_carbon = \Carbon\Carbon::now();
        } else {
            $end_date_carbon = \Carbon\Carbon::parse($end_date);
        }

        $start_date = \Carbon\Carbon::parse($start_date);
        $today = \Carbon\Carbon::now();
    }
}



if (!function_exists("active_routes")) {
    /**
     * Check if given route is active
     * @param array route name
     * @return boolean|string
     * @version 1.0
     */

    function active_routes(array $route_name, $return = "active")
    {
        return (in_array(Route::currentRouteName(), $route_name)) ? $return : null;
    }
}


if (!function_exists("user")) {
    function user() : \App\Models\Member|null
    {
        static $user = null;

        if ($user) return $user;

        $user = auth()->guard('web')->user();
        return $user;
    }
}

if (!function_exists("adminUser")) {
    function adminUser(): AdminUser|null
    {
        static $user = null;

        if ($user) return $user;

        $user = auth()->guard('admin')->user();
        return $user;
    }
}


if (!function_exists("profile")) {
    function profile(?\App\Models\Member $member = null)
    {
        if ( $member ) {
            $memberAccessible = user()->myMembers()->where('student_id', $member->getKey())->first();

            if ( $memberAccessible ) {
                if ( ! $member?->profileImage) {
                    $hash = md5($member->email);
                    return "https://www.gravatar.com/avatar/" . $hash . "/?d=robohash";
                }
                return \App\Classes\Helpers\Image::getImageAsSize($member->profileImage?->filepath, 'xs');

            }
        }
        if (user()) {
            if (! user()?->profileImage) {
                $hash = md5(user()->email);
                return "https://www.gravatar.com/avatar/" . $hash . "/?d=robohash";
            }

            return \App\Classes\Helpers\Image::getImageAsSize(user()->profileImage?->filepath, 'xs');
        }

        if (adminUser()) {
            $hash = md5(adminuser()->email);
            return "https://www.gravatar.com/avatar/" . $hash . "/?d=robohash";
        }
        //
        //        if (user()->profile && isset(user()->profile->full_path) ) {
        //            return user()->profile->full_path;
        //        }
        //
        //        if ( (user()->profile) && isset(user()->profile->path) ) {
        //            return asset(user()->profile->path);
        //        }
        //
        //        if (user()->profileUrl && isset(user()->profileUrl->avatar) ) {
        //            return user()->profileUrl->avatar;
        //        }

    }
}


if (!function_exists("notices")) {
    function notices()
    {
        static $notices = null;

        if ($notices) return $notices;

        //
        if (Cache::has('notices')) {
            return $notices = Cache::get('notices')->where("active", true);
        }
        $notices_db = \App\Models\Notices::latest()->where('active', true)->get();
        Cache::add("notices", $notices_db);
        $notices = Cache::get("notices")->where('active', true);
        return $notices;
    }
}


if (!function_exists("categories")) {
    function categories()
    {

        static $category = null;

        if ($category) return $category;

        $category = \App\Models\Category::get();
        return $category;
    }
}


if (!function_exists("widget_title")) {
    function widget_title($title)
    {
        return ($title == "***DO NOT DISPLAY***") ? "" : $title;
    }
}
