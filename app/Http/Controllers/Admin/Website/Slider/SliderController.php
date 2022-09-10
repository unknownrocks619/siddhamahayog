<?php

namespace App\Http\Controllers\Admin\Website\Slider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Admin\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    //

    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
        return vieW('admin.website.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.website.slider.add');
    }

    public function store(SliderRequest $request)
    {
        $slider = new Slider;
        $slider->title = $request->slider_title;
        $slider->description = $request->image_description;
        $slider->tagline = $request->tagline;
        $slider->display_order = $slider->count() + 1;
        $slider->status = ($request->active) ? true : false;

        $plugins  = [
            "donation" => $request->donation_button,
            "services" =>  $request->join_today,
            "join_now" => $request->services_button
        ];
        $slider->plugins = json_encode($plugins);
        $slider->slider_file = asset(Storage::putFile("slider/", $request->file('slider_image')->path()));

        try {
            $slider->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            $request->session()->flash("error", "Unable to upload Slider File. Please Try again.");
            return back()->withInput();
        }
        Cache::put("slider_settings", Slider::get());

        $request->session()->flash("success", "New Slider image Uploaded.");
        return redirect()->route('admin.website.slider.admin_slider_edit', $slider->id);
    }

    public function edit(Slider $slider)
    {
        return view('admin.website.slider.edit', compact('slider'));
    }

    public function update(SliderRequest $request, Slider $slider)
    {

        $slider->title = $request->slider_title;
        $slider->description = $request->image_description;
        $slider->tagline = $request->tagline;
        $slider->display_order = $slider->count() + 1;
        $slider->status = ($request->active) ? true : false;

        $plugins  = [
            "donation" => $request->donation_button,
            "services" =>  $request->join_today,
            "join_now" => $request->services_button
        ];
        $slider->plugins = json_encode($plugins);

        try {
            $slider->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('error', "Unable to update Slider Information");
            return back()->withInput();
        }
        Cache::put("slider_settings", Slider::get());
        $request->session()->flash('success', "Slider Image Information updated.");
        return back();
    }

    public function delete(Request $request, Slider $slider)
    {

        try {
            $slider->delete();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('error', "Unable to remove slider.");
            return back();
        }

        Cache::put("slider_settings", Slider::get());

        $request->session()->flash('success', "Slider information removed.");
        return redirect()->route('admin.website.slider.admin_slider_index');
    }
}
