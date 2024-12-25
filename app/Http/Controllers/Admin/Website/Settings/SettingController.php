<?php

namespace App\Http\Controllers\Admin\Website\Settings;

use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    //

    public function index()
    {
        $settings = WebSetting::get();

        return view('admin.website.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = WebSetting::get();

        if ($request->hasFile("main_logo")) {
            // upload main logo.
            $settings->where("name", "logo")->first()->value = asset(Storage::putFile('website', $request->main_logo->path()));
            // $uploader->file_type = $request->file('file')->getFileType();
            // $uploader->path =  Storage::putFile('site',$request->file('file')->path());
            $settings->where('name', 'logo')->first()->save();
        }

        if ($request->hasFile("favicon")) {
            $settings->where("name", "favicon")->first()->value = asset(Storage::putFile('website', $request->favicon->path()));
            // $uploader->file_type = $request->file('file')->getFileType();
            // $uploader->path =  Storage::putFile('site',$request->file('file')->path());
            $settings->where('name', 'favicon')->first()->save();
        }

        $settings->where('name', 'cache')->first()->value = ($request->cache) ? true : false;
        $settings->where('name', 'loading_bar')->first()->value = ($request->loading) ? true : false;
        $settings->where('name', 'online_payment')->first()->value = ($request->online_payment) ? true : false;
        $settings->where('name', 'donation')->first()->value = ($request->donation) ? true : false;
        $settings->where('name', 'website_name')->first()->value = ($request->website_name) ? $request->website_name : "Siddhamahayog.org";
        $settings->where('name', "website_url")->first()->value = ($request->website_url) ? $request->website_url : ((env("APP_DEBUG")) ? "localhost:8000" : "https://upschool.co");
        $settings->where('name', "live_show")->first()->value = ($request->live_show) ? true : false;
        $settings->where('name', "official_email")->first()->value = ($request->official_email) ? $request->official_email : "info@siddhamahayog.org";
        $settings->where('name', "company_address")->first()->value = ($request->company_address) ? $request->company_address : "Hanuman Mandir, Dharan, Nepal";
        $settings->where('name', "unpaid_access")->first()->value = ($request->unpaid_access) ? $request->unpaid_access : 5;

        if ($settings->where('name', 'website_name')->first() && $settings->where('name', 'website_name')->first()->isDirty()) {
            $settings->where('name', 'website_name')->first()->save();
            $this->writeEnvironmentFile("APP_NAME", ($settings->where('name', 'website_name')->first()->value));
        }
        if ($settings->where('name', 'website_url')->first() && $settings->where('name', 'website_url')->first()->isDirty()) {
            $settings->where('name', 'website_url')->first()->save();
            $this->writeEnvironmentFile("APP_URL", $settings->where('name', "website_url")->first()->value);
        }

        if ($settings->where('name', 'cache')->first() && $settings->where('name', 'cache')->first()->isDirty()) {
            $settings->where('name', 'cache')->first()->save();
        }
        if ($settings->where('name', 'loading_bar')->first() && $settings->where('name', 'loading_bar')->first()->isDirty()) {
            $settings->where('name', 'loading_bar')->first()->save();
        }

        if ($settings->where('name', 'online_payment')->first() && $settings->where('name', 'online_payment')->first()->isDirty()) {
            $settings->where('name', 'online_payment')->first()->save();
        }
        if ($settings->where('name', 'donation')->first() && $settings->where('name', 'donation')->first()->isDirty()) {
            $settings->where('name', 'donation')->first()->save();
        }

        if ($settings->where('name', 'loading_bar')->first() && $settings->where('name', 'loading_bar')->first()->value && $request->hasFile('loading_bar_image')) {
            $settings->where("name", "loading_bar_image")->first()->value = asset(Storage::putFile('website', $request->loading_bar_image->path()));
            $settings->where('name', 'loading_bar_image')->first()->save();
        }

        if ($settings->where('name', "official_email")->first() && $settings->where('name', "official_email")->first()->isDirty()) {
            $settings->where("name", 'official_email')->first()->save();
        }
        if ($settings->where('name', "company_address")->first() && $settings->where('name', "company_address")->first()->isDirty()) {
            $settings->where("name", 'company_address')->first()->save();
        }
        if ($settings->where('name', "live_show")->first() && $settings->where('name', "live_show")->first()->isDirty()) {
            $settings->where("name", 'live_show')->first()->save();
        }
        if ($settings->where('name', "main_contact")->first() && $settings->where('name', "main_contact")->first()->isDirty()) {
            $settings->where("name", 'main_contact')->first()->save();
        }
        if ($settings->where('name', "unpaid_access")->first() && $settings->where('name', "unpaid_access")->first()->isDirty()) {
            $settings->where("name", 'unpaid_access')->first()->save();
        }

        Cache::put("web_settings", $settings);
        return $this->json(true,'Setting Updated.');
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
