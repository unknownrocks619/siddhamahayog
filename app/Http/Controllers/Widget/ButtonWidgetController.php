<?php

namespace App\Http\Controllers\Widget;

use App\Models\Widget;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ButtonWidgetController extends Controller
{
    //

    public function create() {
        return view('widget.items.buttons.create');
    }

    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            // "button_name" => "required",
            "button_type" => "required|in:external_link,force_download",
            "download_button_label" => "required_if:button_type,force_download",
            "button_label" => "required_if:button_type,external_link",
            "external_url" => "required_if:button_type,external_link"
        ]);


        // DB Widgets and Model Widget should exists.
        $widget = new Widget;
        $widget->widget_name = $request->button_name;
        $widget->slug = Str::slug($request->button_name,"-");
        $widget->widget_type = "button";
        $widgets = [];

        if ($request->button_type == "external_link") {
            foreach ($request->button_label as $key => $value){
                $settings = [
                    "type" => "external_link",
                    "target" => "_blank",
                    "href" => $request->external_url[$key],
                    "label" => $request->button_label[$key]
                ];

                $widgets[] = $settings;
            }
        }

        if ( $request->button_type == "force_download") {
            foreach ($request->download_button_label as $key => $value) {
                
                // dd($request->file("download_file")[$key]->getClientOriginalName());
                $settings = [
                    "type" => "download",
                    "target" => "_blank",
                    "download" => [
                        "type" => $request->file("download_file")[$key]->getMimeType(),
                        "path" => Storage::putFile("website/widgets",$request->file("download_file")[$key]->path()),
                        "original_filename" => $request->file("download_file")[$key]->getClientOriginalName()
                    ],
                    "label" => $value
                ];
                $widgets[] = $settings;
            }

        }
        $widget->widgets = json_encode($widgets);
        
        try {
            $widget->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error","Unable to create button widget. Error: ". $th->getMessage());
            return redirect()->route('admin.widget.create');
        }

        session()->flash("success","Button Widget Created.");
        return redirect()->route('admin.widget.create');


    }

    public function update(Request $request, Widget $widget) {
         // dd($request->all());
         $request->validate([
            // "button_name" => "required",
            "button_type" => "required|in:external_link,force_download",
            "download_button_label" => "required_if:button_type,force_download",
            "button_label" => "required_if:button_type,external_link",
            "external_url" => "required_if:button_type,external_link"
        ]);

        $widget->widget_name = $request->button_name;
        $widget->slug =  ($widget->isDirty("widget_name")) ? Str::slug($request->button_name,"-") : $widget->slug;
        $widget->widget_type = "button";
        $widgets = [];

        if ($request->button_type == "external_link") {
            foreach ($request->button_label as $key => $value){
                $settings = [
                    "type" => "external_link",
                    "target" => "_blank",
                    "href" => $request->external_url[$key],
                    "label" => $value
                ];

                $widgets[] = $settings;
            }
        }

        if ( $request->button_type == "force_download") {
            foreach ($request->button_label as $key => $value) {
                $settings = [
                    "type" => "download",
                    "target" => "_blank",
                    "download" => [
                        "type" => $request->file("download_file")[$key]->getMimeType(),
                        "path" => Storage::putFile("website/widgets",$request->file("download_file")[$key]->path()),
                        "original_filename" => $request->file("download_file")[$key]->getClientOriginalName()
                    ],
                    "label" => $value
                ];

                $widget[] = $settings;
            }

        }
        $widget->widgets = json_encode($widgets);
        
        try {
            $widget->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error","Unable to update widget. Error: ". $th->getMessage());
            return redirect()->route('admin.widget.create');
        }

        session()->flash("success","Widget information Updated.");
        return redirect()->route('admin.widget.create');


    }
}
