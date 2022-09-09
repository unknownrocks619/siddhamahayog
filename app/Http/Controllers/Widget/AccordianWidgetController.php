<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadHandler;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class AccordianWidgetController extends Controller
{
    //
    use UploadHandler;
    public function create()
    {
        return view("widget.items.accordian.create");
    }

    public function store(Request $request)
    {


        $widget = new Widget();

        $widget->widget_name = $request->widget_name;
        $widget->widget_title = $request->widget_title;
        $widget->widget_description = $request->widget_content_description;
        $widget_featured_image = [];

        if ($request->hasFile("front_image")) {
            $this->set_upload_path("website/widgets");
            $widget_featured_image["front_image"] = $this->upload($request, "front_image");
        }

        if ($request->hasFile("top_back_image")) {
            $this->set_upload_path("website/widgets");
            $widget_featured_image["top_back_image"] = $this->upload($request, "top_back_image");
        }

        if ($request->hasFile("bottom_back_image")) {
            $this->set_upload_path("website/widgets");
            $widget_featured_image["bottom_back_image"] = $this->upload($request, "bottom_back_image");
        }
        $widget->widget_featured_images = json_encode($widget_featured_image);

        $widget->slug = Str::slug($request->widget_name, "-");
        $widget->widget_type = "according";

        $widgets = [];
        $id =  rand(150, 1000);

        foreach ($request->accordian_title as $key => $value) {
            $id++;
            $innerArray = [];

            if ($request->accordian_featured_image && $request->hasFile($request->accordian_featured_image)) {
                $image =  [
                    "type" => $request->file("accordian_featured_image")[$key]->getMimeType(),
                    "path" => Storage::putFile("website/widgets", $request->file("accordian_featured_image")[$key]->path()),
                    "original_filename" => $request->file("accordian_featured_image")[$key]->getClientOriginalName()

                ];

                $innerArray["featured_image"] = $image;
            }
            $innerArray["id"] = "widget_according_" . $id;
            $innerArray["according_title"] = $value;
            $innerArray["content"] = $request->accordian_content[$key];

            $widgets[] = $innerArray;
        }

        $widget->widgets = json_encode($widgets);

        try {
            //code...
            $widget->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to create accordian widget. Error: " . $th->getMessage());
            return redirect()->route('admin.widget.create');
        }

        session()->flash('success', "New Accordian Widget Created.");
        return redirect()->route('admin.widget.create');
    }

    public function update(Request $request, Widget $widget)
    {
        $widget->widget_name = $request->widget_name;
        $widget->slug = ($widget->isDirty("widget_name")) ? Str::slug($request->widget_name, "-") : $widget->slug;
        $widgets = [];
        $id =  rand(150, 1000);
        foreach ($request->accordian_title as $key => $value) {
            $id++;
            $innerArray = [];

            if ($request->accordian_featured_image && $request->hasFile($request->accordian_featured_image)) {
                $image =  [
                    "type" => $request->file("accordian_featured_image")[$key]->getMimeType(),
                    "path" => Storage::putFile("website/widgets", $request->file("accordian_featured_image")[$key]->path()),
                    "original_filename" => $request->file("accordian_featured_image")[$key]->getClientOriginalName()

                ];

                $innerArray["featured_image"] = $image;
            }
            $innerArray["id"] = "widget_according_" . $id;
            $innerArray["according_title"] = $value;
            $innerArray["content"] = $request->accordian_content[$key];

            $widgets[] = $innerArray;
        }

        $widget->widgets = json_encode($widgets);

        try {
            //code...
            $widget->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to update accordian widget.");
            return redirect()->route('admin.widget.create');
        }
        session()->flash('success', "Accordian Widget updated.");
        return redirect()->route('admin.widget.create');
    }
}
