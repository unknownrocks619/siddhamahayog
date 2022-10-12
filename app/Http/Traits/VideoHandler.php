<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


trait VideoHandler
{

    private $source;
    private $allowed_source = ["youtube", "vimeo"];

    protected function set_source($source)
    {

        if (in_array(strtolower($source), $this->allowed_source)) {
            $this->source = $source;
        }
    }

    protected function get_source()
    {
        return $this->source;
    }

    public function video_parts($url)
    {

        
        if ($this->get_source() == "youtube") {
            $youtube_url = Str::of($url)->after("?v=")->before("&")->value;
            $source_encode = [
                "source" => "youtube",
                "link" => $url,
                "id" => $youtube_url,
                "thumbnail" => "http://img.youtube.com/vi/{$youtube_url}/maxresdefault.jpg"
            ];
            return $source_encode;
        }

        if ($this->get_source() == "vimeo") {
            $vimeo_url = Str::of($url)->afterLast("/")->value;
            $video_api  = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $vimeo_url . ".php"));
            $image = null;
            if (is_array($video_api) && count($video_api) > 0) {
                $thumb_info = $video_api[0];
                $image = $thumb_info['thumbnail_large'];
            }
            $source_encode = [
                "source" => "vimeo",
                "link" => $url,
                "id" => $vimeo_url,
                "thumbnail" => $image
            ];

            return $source_encode;
        }
    }
}
