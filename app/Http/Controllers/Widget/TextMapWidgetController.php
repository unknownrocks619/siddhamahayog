<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TextMapWidgetController extends Controller
{
    public function create()
    {
        return view('widget.items.text_map.create');
    }

    public function store(Request $request)
    {

        $widget = new Widget;
        $widget->widget_name = $request->widget_name;
        $widget->slug = Str::slug($request->widget_name, "-");
        $widget->widget_type = "text_map";
        $widgets = [];
        $id =  rand(150, 1000);
        foreach ($request->text_title as $key => $value) {
            $id++;
            $innerArray = [];
            // $maps = [
            //     "full_url" => $request->map_link[$key],
            //     "id" => Str::afterLast($request->map_link[$key], "/"),
            // ];
            $innerArray["map"] = $request->map_link[$key];
            $innerArray["id"] = "widget_text_map_" . $id;
            $innerArray["title"] = $value;
            $innerArray["content"] = $request->text_content[$key];
            $widgets[] = $innerArray;
        }

        $widget->widgets = json_encode($widgets);

        try {
            //code...
            $widget->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to create widget. Error: " . $th->getMessage());
            return redirect()->route('admin.widget.create');
        }

        session()->flash('success', "New Widget Created.");
        return redirect()->route('admin.widget.create');
    }
}
