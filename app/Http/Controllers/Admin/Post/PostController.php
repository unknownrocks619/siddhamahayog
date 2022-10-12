<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\PostStoreRequest;
use App\Http\Requests\Admin\Post\PostUpdateRequest;
use App\Http\Traits\VideoHandler;
use App\Models\Post;
use App\Models\Widget;
// use App\Traits\VideoHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Upload\Media\Traits\FileUpload;

class PostController extends Controller
{
    //
    use VideoHandler, FileUpload;
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.post.index', compact("posts"));
    }

    public function create()
    {
        return view("admin.post.create");
    }

    public function store(PostStoreRequest $request)
    {
        $post = new Post;
        $post->title = $request->post_title;
        $post->short_description = $request->short_description;
        $post->full_description = $request->full_description;
        $post->slug = Str::slug($request->post_title, "-");
        $post->post_type = $request->post_type;
        $post->active  = ($request->active) ? true : false;
        $images = [];
        if ($request->hasFile("featured_image")) {
            $this->set_access("file");
            $this->set_upload_path("website/posts");

            $images["featured_image"] = $this->upload("featured_image");
        }

        if ($request->hasFile("banner_image")) {
            $this->set_access("file");
            $this->set_upload_path("website/posts");
            $images["banner_image"] = $this->upload("banner_image");
        }

        $post->images = $images;

        $videos = [];
        if ($request->featured_video) {
            $this->set_source(Str::contains("vimeo", $request->featured_video, true) ? "vimeo" : "youtube");
            $videos["featured_video"] = $this->video_parts($request->featured_video);
        }
        if ($request->banner_video) {
            $this->set_source(Str::contains("vimeo", $request->banner_video, true) ? "vimeo" : "youtube");
            $videos["banner_video"] = $this->video_parts($request->banner_video);
        }

        $post->videos = $videos;
        try {
            $post->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Error : " . $th->getMessage());
            return back()->withInput();
        }

        session()->flash("success", "New Post Created");
        return back();
    }

    public function edit(Post $post)
    {
        return view('admin.post.edit', compact('post'));
    }


    public function update(PostUpdateRequest $request, Post $post)
    {
        $post->title = $request->post_title;
        $post->short_description = $request->short_description;
        $post->full_description = $request->full_description;
        $post->slug = Str::slug($request->post_title, "-");
        $post->post_type = $request->post_type;
        $post->active  = ($request->active) ? true : false;
        $images = (array) $post->images;
        if ($request->hasFile("featured_image")) {
            $this->set_access("file");
            $this->set_upload_path("website/posts");

            $images["featured_image"] = $this->upload("featured_image");
        }

        if ($request->hasFile("banner_image")) {
            $this->set_access("file");
            $this->set_upload_path("website/posts");
            $images["banner_image"] = $this->upload("banner_image");
        }

        $post->images = $images;

        $videos = (array) $post->videos;
        if ($request->featured_video) {
            $this->set_source(Str::contains("vimeo", $request->featured_video, true) ? "vimeo" : "youtube");
            $videos["featured_video"] = $this->video_parts($request->featured_video);
        }
        if ($request->banner_video) {
            $this->set_source(Str::contains("vimeo", $request->banner_video, true) ? "vimeo" : "youtube");
            $videos["banner_video"] = $this->video_parts($request->banner_video);
        }

        $post->videos = $videos;
        try {
            $post->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Error : " . $th->getMessage());
            return back()->withInput();
        }

        session()->flash("success", "Post Updated");
        return back();
    }

    public function destroy(Post $post)
    {
        try {
            DB::transaction(function () use ($post) {
                $post->menu()->detach();
                $post->widgets()->detach();
                $post->delete();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Error: " . $th->getMessage());
            return back();
        }
        session()->flash('success', "Post removed.");
        return back();
    }

    public function removeMedia(Request $request, Post $post)
    {
        $request->validate([
            "slug" => "required",
            "type" => "required|in:image,video"
        ]);

        $remove = $request->slug;
        if ($request->type == "image") {
            if ($post->images && isset($post->images->$remove)) {
                $images = (array) $post->images;
                unset($images[$remove]);
                $post->images = $images;
            }
        }

        if ($request->type == "video") {
            if ($post->videos && isset($post->videos->$remove)) {
                $videos = (array) $post->videos;
                unset($videos[$remove]);
                $post->videos = $videos;
            }
        }
        try {
            if ($post->isDirty(["images", "videos"])) {
                $post->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "success" => false,
                "message" => "Unable to remove media",
                "error" => $th->getMessage()
            ]);
        }

        return response([
            "success" => true,
            "message" => "Media Removed",
        ]);
    }

    public function widgetView(Post $post)
    {
        $post = $post->load(['widgets' => fn ($query) =>  $query->orderBy("sort_by")]);
        return view('admin.post.widgets.manage', compact("post"));
    }

    public function widgetAdd(Post $post)
    {
        $widgets = Widget::latest()->get();

        return view("admin.post.widgets.add", compact('post', 'widgets'));
    }

    public function widgetStore(Request $request, Post $post)
    {
        $request->validate(["widget" => "required"]);
        if (!$post->widgets()->count()) {
            $pivot["sort_by"] = 1;
        } else {
            $pivot["sort_by"] = $post->widgets()->max("sort_by") + 1;
        }
        $post->widgets()->attach($request->widget, $pivot);
        return response()->json("Widget Added");
    }

    public function widgetDestroy(Request $request, Post $post, Widget $widget)
    {

        try {
            $post->widgets()->detach($widget->id);
        } catch (\Throwable $th) {
            //throw $th;

            if ($request->ajax()) {
                return response([
                    "succcess" => false,
                    "error" => $th->getMessage(),
                    "message" => "unable to deatch widget."
                ]);
            }

            session()->flash("error", "Unable to deatch widget");
            return back();
        }


        if ($request->ajax()) {
            return response([
                "success" => true,
                "message" => "Widgets Removed.",
                "link" => ($post->widgets()->coun()) ? "" : "<span class='badge badge-info'>No Widgets</span>"
            ]);
        }

        session()->flash('success', "Widget Removed");
        return back();
    }
}
