<?php

namespace App\Http\Controllers\Admin\Notice;

use App\Http\Controllers\Controller;
use App\Http\Traits\VideoHandler;
use App\Models\Notices;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Nullable;
use Upload\Media\Traits\FileUpload;
use Illuminate\Support\Str;
use PHPUnit\Framework\Error\Notice;

class Noticecontroller extends Controller
{
    //
    use VideoHandler, FileUpload;

    public function index()
    {
        $notices = Notices::latest()->get();
        return view("admin.notice.index", compact('notices'));
    }

    public function create()
    {
        return view("admin.notice.add");
    }

    public function store(Request $request)
    {
        $notice = new Notices;
        $notice->title = $request->title;
        $notice->notice = $request->notice;
        $notice->active = $request->active;
        $notice->target = 'all';
        $notice->notice_type = $request->notice_type;

        if ($notice->notice_type == "image") {
            $this->set_access("file");
            $this->set_upload_path("website/notices");
            $notice->settings = $this->upload("image");
        }

        if ($notice->notice_type == "video") {
            $this->set_source(Str::contains($request->video_url, "youtube", true) ? "youtube" : 'vimeo');

            $notice->settings = $this->video_parts($request->video_url);
        }

        try {
            $notice->save();
        } catch (\Throwable $th) {
            return $this->json(false,"Error: ". $th->getMessage());
            //throw $th;
            session()->flash('error', "Error: " . $th->getMessage());
            return back();
        }
        return $this->json(true,'Notice Saved.','redirect',['location'=>route('admin.notices.notice.edit',['notice' => $notice])]);
        session()->flash("success", "Notice Saved.");
        return back();
    }

    public function edit(Notices $notice)
    {
        return view("admin.notice.edit",['notice' => $notice]);

    }

    public function update(Request $request, Notices $notice)
    {
        $notice->title = $request->title;
        $notice->notice = $request->notice;
        $notice->active = $request->active;
        $notice->target = 'all';
        $notice->notice_type = $request->notice_type;

        if ($notice->notice_type == "image" && $request->file('image')) {
            $this->set_access("file");
            $this->set_upload_path("website/notices");
            $notice->settings = $this->upload("image");
        }

        if ($notice->notice_type == "video") {
            $this->set_source(Str::contains($request->video_url, "youtube", true) ? "youtube" : 'vimeo');

            $notice->settings = $this->video_parts($request->video_url);
        }

        try {
            $notice->save();
        } catch (\Throwable $th) {
            return $this->json(false,"Error: ". $th->getMessage());
        }

        return $this->json(true,'Notice Saved.','redirect',['location'=>route('admin.notices.notice.edit',['notice' => $notice])]);

    }

    public function destroy(Notices $notice)
    {
        if (! $notice->delete() ) {
            return $this->json(false,'Unable to delete Notice.');
        }

        return $this->json(true,'Notice removed.','reload');
    }
}
