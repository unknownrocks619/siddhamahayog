<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FAQWidgetController extends Controller
{
    //

    public function create() {
        return view('widget.items.faq.create');
    }

    public function store(Request $request) {

        // dd($request->all());
        $widget = new Widget;

        $widget->widget_name = $request->widget_name;
        $widget->slug = Str::slug($request->widget_name,"-");
        $widget->widget_type = "faq";
        $widgets = [];
        $id =  rand(150,1000);
        foreach ($request->faq_title as $key => $value) {
            $id++;
            $innerArray = [];

            $innerArray["id"] = "widget_faq_".$id;
            $innerArray["title"] = $value;
            $innerArray["content"] = $request->faq_content [$key];

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
