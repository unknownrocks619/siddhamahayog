<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Widget\Accordian\AccordianStoreRequest;
use App\Http\Requests\Admin\Widget\Accordian\AccordianUpdateRequest;
use App\Models\Widget;
use App\Traits\VideoHandler;
use Illuminate\Http\Request;
use Upload\Media\Traits\FileUpload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class WidgetController extends Controller
{
    //
    use FileUpload, VideoHandler;
    public function index()
    {
        $widgets = Widget::get()->groupBy("widget_type");
        // $widget_type = $widgets->pluck("widget_type");
        return view("admin.widgets.index", compact("widgets"));
    }

    public function filterIndex(Request $request)
    {
        $widgets = Widget::where('widget_type', $request->type)->get();
        $widget_type = $request->type;
        return view('admin.widgets.index.items_by_type', compact('widgets', 'widget_type'));
    }

    public function edit(Widget $widget)
    {
        return view('admin.widgets.edit.' . $widget->widget_type, compact('widget'));
    }

    public function create()
    {
        return view('admin.widgets.create');
    }

    public function store(AccordianStoreRequest $request)
    {
        $widget = new Widget;

        $widget->widget_name = $request->widget_name;
        $widget->slug = Str::slug($request->widget_name);
        $widget->widget_type = $request->widget_type;
        $settings = [];
        if ($request->background_color) {
            $settings = ["theme_color" => $request->background_color];
        }

        if ($request->featured_video == "yes") {
            $settings["featured"] = ($request->featured_video == "yes") ? true : false;
        }
        $widget->settings = $settings;
        $fields = [];
        $this->set_upload_path("website/widgets");
        $this->set_access("file");
        foreach ($request->title as $key => $title) {
            $innerArray = [];
            $innerArray["title"] = $title;
            $innerArray["image"] = [];
            $has_file = (isset($request->image[$key]) && ($request->image[$key])) ? $request->image[$key] : null;
            if ($has_file) {
                $innerArray["image"] = $this->upload_by_resource($has_file);
            }
            $innerArray["content"] = $request->widget_content[$key];
            if ($request->icons && isset($request->icons[$key])) {
                $innerArray["icon"] = $request->icons[$key];
            }
            if ($request->button_category) {
                $innerArray["button_action"] = $request->button_category;
            }
            if ($request->video_link && isset($request->video_link[$key])) {

                Str::contains($request->video_link[$key], "youtube") ? $this->set_source("youtube") : $this->set_source("vimeo");

                $innerArray["video"] = $this->video_parts($request->video_link[$key]);
            }

            // if ($request->featured_video && $request->featured_video == "yes") {
            //     $innerArray["featured"]  = true;
            // }

            $fields[] = $innerArray;
        }
        $widget->fields = $fields;
        $widget->layouts = ["layout" => $request->layout];

        try {
            $widget->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            session()->flash('error', "Unable to create widget. " . $th->getMessage());
            return back()->withInput();
        }

        session()->flash('success', "New Widget Created.");
        return redirect()->route('admin.web.widget.index');
    }

    public function update(AccordianUpdateRequest $request, Widget $widget)
    {
        $widget->widget_name = $request->widget_name;
        $widget->layouts = ["layout" => $request->layout];
        if ($widget->isDirty("widget_name")) {
            $widget->slug = Str::slug($request->widget_name);
        }

        $fields = [];
        $this->set_upload_path("website/widgets");
        $this->set_access("file");
        foreach ($request->title as $key => $title) {
            $innerArray = [];
            $innerArray["title"] = $title;
            $innerArray["image"] = [];
            $has_file = (isset($request->image[$key]) && $request->image[$key]) ? $request->image[$key] : false;
            if ($has_file && $request->hasFile("image")) {

                $innerArray["image"] = $this->upload_by_resource($has_file);
            } else {

                $innerArray["image"] = (isset($widget->fields[$key])) ? $widget->fields[$key]->image : [];
            }
            $innerArray["content"] = $request->widget_content[$key];
            if ($request->icons && isset($request->icons[$key])) {
                $innerArray["icon"] = $request->icons[$key];
            }

            if ($request->button_category) {
                $innerArray["button_action"] = $request->button_category;
            }

            if ($request->video_link && isset($request->video_link[$key])) {

                Str::contains($request->video_link[$key], "youtube") ? $this->set_source("youtube") : $this->set_source("vimeo");
                $innerArray["video"] = $this->video_parts($request->video_link[$key]);
            }

            $fields[] = $innerArray;
        }

        $widget->fields = $fields;
        $settings = array($widget->settings);
        if ($request->background_color) {
            $settings["them_color"] = $request->background_color;
        }
        if ($request->featured_video == "yes") {
            $settings["featured"] = ($request->featured_video == "yes") ? true : false;
        }
        $widget->settings = $settings;
        try {
            $widget->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            return back()->withInput();
        }

        session()->flash("success", "Widget Updated.");
        return redirect()->route('admin.web.widget_by_type', ['type' => $widget->widget_type]);
    }

    public function destroy(Widget $widget)
    {
        try {
            $widget->delete();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "unable to remove widget.");
            return back();
        }

        session()->flash('success', 'Widget Removed.');
        return back();
    }
}
