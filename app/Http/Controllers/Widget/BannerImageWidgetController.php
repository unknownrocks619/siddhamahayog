<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BannerImageWidgetController extends Controller
{
    //

    public function create () {
        return view('widget.items.banner_image.create');
    }

    public function store(Request $request) {
        $widget = new Widget;
        $widget->widget_name = $request->widget_name;
        $widget->slug = Str::slug($request->widget_name,"-");
        $widget->widget_type = "banner_image";
        $widgets = [];
        $id =  rand(150,1000);
        foreach ($request->text_title as $key => $value) {
            $id++;
            $innerArray = [];
            if ($request->hasFile("text_file") && isset ($request->file("text_file")[$key])) {
                $image =  [
                    "type" => $request->file("text_file")[$key]->getMimeType(),
                    "path" => Storage::putFile("website/widgets",$request->file("text_file")[$key]->path()),
                    "original_filename" => $request->file("text_file")[$key]->getClientOriginalName()

                ];

                $innerArray["featured_image"] = $image;
            }

            $innerArray["id"] = "widget_text_image_".$id;
            $innerArray["title"] = $value;
            $innerArray["content"] = $request->text_content [$key];
            $widgets[] = $innerArray;
        }

        $widget->widgets = json_encode($widgets);

        try {
            //code...
            $widget->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error',"Unable to create widget. Error: ". $th->getMessage());
            return redirect()->route('admin.widget.create');
        }

        session()->flash('success',"New Widget Created.");
        return redirect()->route('admin.widget.create');
    }


}
