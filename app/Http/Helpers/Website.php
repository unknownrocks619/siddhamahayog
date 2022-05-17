<?php

use App\Models\Menu;
use App\Models\Program;
use App\Models\Slider;
use App\Models\SliderSetting;
use Illuminate\Support\Facades\Cache;

if (! function_exists("site_settings") ) {

    function site_settings($key = null) {

        if ( Cache::has("web_settings") ) {
            $settings = Cache::get("web_settings");
        } else {
            $settings = \App\Models\WebSetting::get();
        }

        return ($key) ? $settings->where('name',$key)->first()->value : $settings;

    }

}

if ( ! function_exists("menus") ) {

    function menus($search = []) {
        $cache = true;
        if ( ! site_settings("cache") ) {
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

if (! function_exists('programs') ) {

    function programs($types = null) {
        if (Cache::has('programs') ) {
            $all_programs = Cache::get('programs')->where('status','active');
        } else {
            $all_programs = Program::where('status','active')->get();
        }

        if ($types ) {
            return $all_programs->where('program_type',$types);
        }
        
        return $all_programs;
    }

}


if ( ! function_exists("plugins_slider") ) {

    function plugins_slider() {


        if (Cache::has("slider_settings") ) {
            return Cache::get('slider_settings');
        } else {
            return Slider::latest()->get();
        }
    }
}

if (! function_exists("cache_website") ) {

    function cache_website($cache_name , $cache) {
        $cache_names = [
            "web_settings",
            "menus",
            "page_settings",
            "post_settings",
            "event_settings",
            "slider_settings"
        ];

        Cache::put($cache_name,$cache);
    }
}


if ( ! function_exists("event_status") ) {

    function event_status($start_date,$end_date = null) {

        if (! $end_date ) {
            $end_date_carbon = \Carbon\Carbon::now();
        } else  {
            $end_date_carbon = \Carbon\Carbon::parse($end_date);
        }

        $start_date = \Carbon\Carbon::parse($start_date);
        $today = \Carbon\Carbon::now();
    }
}

?>