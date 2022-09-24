<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Upload\Media\Traits\FileUpload;

class WebSettingController extends Controller
{
    //
    use FileUpload;

    public function index()
    {
        $settings = settings();
        return view("admin.web_settings.index", compact("settings"));
    }

    public function Update(Request $request)
    {
        $this->set_access("file");
        $settings = WebSetting::get();
        if ($request->hasFile("main_logo")) {
            // upload main logo.
            $settings->where("name", "logo")->first()->value = asset(Storage::putFile('website', $request->main_logo->path()));
            $settings->where('name', 'logo')->first()->save();
        }

        if ($request->hasFile("favicon")) {
            $settings->where("name", "favicon")->first()->value = asset(Storage::putFile('website', $request->favicon->path()));
            $settings->where('name', 'favicon')->first()->save();
        }
        $settings->where('name', 'cache')->first()->value = ($request->cache == "on") ? true : (($request->cache == "off") ? false : $settings->where('name', 'cache')->first()->value);
        $settings->where('name', 'login')->first()->value = ($request->login == "on") ? true : (($request->login == "off") ? false : $settings->where('name', 'login')->first()->value);
        $settings->where('name', 'signup')->first()->value = ($request->signup == "on") ? true : (($request->signup == "off") ? false : $settings->where('name', 'signup')->first()->value);
        $settings->where('name', 'facebook_login')->first()->value = ($request->facebook_login == "on") ? true : (($request->facebook_login == "off") ? false : $settings->where('name', 'facebook_login')->first()->value);
        $settings->where('name', 'pre_registration')->first()->value = ($request->pre_registration == "on") ? true : (($request->pre_registration == "off") ? false : $settings->where('name', 'pre_registration')->first()->value);
        $settings->where('name', 'loading_bar')->first()->value = ($request->loading  == "on") ? true : false;
        $settings->where('name', 'website_name')->first()->value = ($request->website_name) ? $request->website_name : $settings->where('name', "website_name")->first()->value;
        $settings->where('name', 'main_contact')->first()->value = ($request->main_contact) ? $request->main_contact : $settings->where('name', "main_contact")->first()->value;
        $settings->where('name', "website_url")->first()->value = ($request->website_url) ? $request->website_url : ((env("APP_DEBUG")) ? "localhost:8000" : "https://upschool.co");
        $settings->where('name', "official_email")->first()->value = ($request->official_email) ? $request->official_email : $settings->where('name', "official_email")->first()->value;
        $settings->where('name', "company_address")->first()->value = ($request->company_address) ? $request->company_address : $settings->where('name', "company_address")->first()->value;
        if ($settings->where('name', 'website_name')->first()->isDirty()) {
            $settings->where('name', 'website_name')->first()->save();
            // $this->writeEnvironmentFile("APP_NAME", ($settings->where('name', 'website_name')->first()->value));
        }
        if ($settings->where('name', 'website_url')->first()->isDirty()) {
            $settings->where('name', 'website_url')->first()->save();
            $this->writeEnvironmentFile("APP_URL", $settings->where('name', "website_url")->first()->value);
        }

        if ($settings->where('name', 'cache')->first()->isDirty()) {
            $settings->where('name', 'cache')->first()->save();
        }
        if ($settings->where('name', 'loading_bar')->first()->isDirty()) {
            $settings->where('name', 'loading_bar')->first()->save();
        }

        if ($settings->where('name', 'loading_bar')->first()->value && $request->hasFile('loading_bar_image')) {
            $settings->where("name", "loading_bar_image")->first()->value = asset(Storage::putFile('website', $request->loading_bar_image->path()));
            $settings->where('name', 'loading_bar_image')->first()->save();
        }

        if ($settings->where('name', "official_email")->first()->isDirty()) {
            $settings->where("name", 'official_email')->first()->save();
        }
        if ($settings->where('name', "company_address")->first()->isDirty()) {
            $settings->where("name", 'company_address')->first()->save();
        }
        if ($settings->where('name', "main_contact")->first()->isDirty()) {
            $settings->where("name", 'main_contact')->first()->save();
        }

        if ($settings->where('name', 'facebook_login')->first()->isDirty()) {
            $settings->where('name', 'facebook_login')->first()->save();
        }
        if ($settings->where('name', 'login')->first()->isDirty()) {
            $settings->where('name', 'login')->first()->save();
        }
        if ($settings->where('name', 'signup')->first()->isDirty()) {
            $settings->where('name', 'signup')->first()->save();
        }
        if ($settings->where('name', 'pre_registration')->first()->isDirty()) {
            $settings->where('name', 'pre_registration')->first()->save();
        }
        if ($settings->where('name', 'main_contact')->first()->isDirty()) {
            $settings->where('name', 'main_contact')->first()->save();
        }
        session()->flash('success', "Setting Updated.");
        return back();
    }

    public function writeEnvironmentFile($key, $value)
    {
        $path = base_path('.env');

        if (is_bool(env($key))) {
            $old = env($key) ? 'true' : 'false';
        } else {
            $old = env($key);
        }

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "$key=" . $old,
                "$key=" . $value,
                file_get_contents($path)
            ));
        }
    }
}
