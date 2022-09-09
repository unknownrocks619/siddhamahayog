<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Widget;
use Illuminate\Support\Str;

class BannerCheckmarkWidgetController extends Controller
{
    //

    public function create() {
        return view("widget.items.banner_checkmark.create");
    }

    public function store(Request $request) {
        $widget = new Widget;

        $widget->widget_name = $request->widget_name;
        $widget->slug = Str::slug($request->widget_name,"-");
        $widget->widget_type = "banner_video_checkmark";
        $widgets = [];

        $id =  rand(150,1000);
        foreach ($request->text_title as $key => $value) {
            $id++;
            $innerArray = [];

            $innerArray["id"] = "widget_banner_checkmark_video_".$id;
            $innerArray["title"] = $value;
            $innerArray["content"] = $request->text_content [$key];
            // video management.
            $prase_url = parse_url($request->video_link [$key] );

            $current_host = strtolower (Str::of($prase_url["host"])->after('.')->before("."));
           

            if ($current_host  == "youtube") {
                $id = Str::of($request->video_link[$key])->after("?v=")->before("&")->value;
                $video_encode= [
                    "source" => "youtube",
                    "link" => $request->video_link[$key],
                    "id" => $id,
                    "thumbnail" => "http://img.youtube.com/vi/{$id}/maxresdefault.jpg"
                ];

                $innerArray["video"] = $video_encode;
            } else  {
                $id = Str::of($request->video_link[$key])->afterLast("/")->value;
                $video_api  = unserialize( file_get_contents( "http://vimeo.com/api/v2/video/".$id.".php" ) );
                $image = null;
                    if ( is_array( $video_api ) && count( $video_api ) > 0 ) {
                        $thumb_info = $video_api[0];
                        $image = $thumb_info['thumbnail_large'];
                    }
                $video_encode = [
                    "source" => "vimeo",
                    "link" => $request->video_link[$key],
                    "id" => $id,
                    "thumbnail" => $image
                ];
                $innerArray["video"] = $video_encode;
            }

            // $innerArray["video"] => 
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
