<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\PageStoreRequest;
use App\Models\Page;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Upload\Media\Traits\FileUpload;

class PageController extends Controller
{
    //
    use FileUpload;

    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.page.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.page.create');
    }

    public function store(PageStoreRequest $request)
    {
        $page = new Page;
        $page->page_name = $request->page_name;
        $page->slug = Str::slug($request->page_name, "-");
        $page->excerpt = $request->short_description;
        $page->description = $request->page_description;
        $page->page_type = $request->page_type;
        $page->display = $request->display_option;

        if ($request->hasFile("banner_image")) {
            $this->set_access("file");
            $this->set_upload_path("website/page");
            $page->image["banner_image"] = $this->upload("banner_image");
        }

        if ($request->hasFile("featured_image")) {
            $this->set_access("file");
            $this->set_upload_path("website/page");
            $page->image["featured_image"] = $this->upload("featured_image");
        }

        try {
            $page->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            session()->flash("error", "Unable to create page.");
            return back()->withInput();
        }
        // dd("")
        session()->flash('success', "Page Created.");
        return back();
    }
    public function edit(Page $page)
    {
        return view("admin.page.edit", compact("page"));
    }
    public function update(PageStoreRequest $request, Page $page)
    {
        $page->page_name = $request->page_name;
        $page->slug = ($request->slug) ? strtolower($request->slug) : Str::slug($request->page_name, "-");
        if ($page->isDirty("page_name")) {
        }
        $page->excerpt = ($request->short_description) ? $request->short_description : $page->short_description;
        $page->description = $request->page_description;
        $page->page_type = $request->page_type;
        $page->display = $request->display_option;

        if ($request->hasFile("banner_image")) {
            $this->set_access("file");
            $this->set_upload_path("website/page");
            $page->image["banner_image"] = $this->upload("banner_image");
        }

        if ($request->hasFile("featured_image")) {
            $this->set_access("file");
            $this->set_upload_path("website/page");
            $page->image["featured_image"] = $this->upload("featured_image");
        }

        try {
            $page->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to create page.");
            return back()->withInput();
        }

        session()->flash('success', "Page Created.");
        return back();
    }

    public function widgetAdd(Page $page)
    {
        $widgets = Widget::latest()->get();

        return view("admin.page.modal.widget-add", compact('page', 'widgets'));
    }

    public function widgetStore(Request $request, Page $page)
    {
        $request->validate(["widget" => "required"]);
        if (!$page->widget()->count()) {
            $pivot["sort_by"] = 1;
        } else {
            $pivot["sort_by"] = $page->widget()->max("sort_by") + 1;
        }
        $page->widget()->attach($request->widget, $pivot);
        return response()->json("Widget Added");
    }

    public function widgetView($page)
    {
        $page = Page::with(['widget' => fn ($query) =>  $query->orderBy("sort_by")])->find($page);
        return view('admin.page.widget', compact('page'));
    }

    public function widgetDestroy(Page $page, Widget $widget)
    {
        try {
            $page->widget()->detach($widget->id);
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to remove widget");

            return back();
        }
        session()->flash("success", "Widget Removed.");

        return back();
    }

    public function destroy(Page $page)
    {

        try {
            //code..
            DB::transaction(function () use ($page) {
                $page->widget()->detach();
                $page->menus()->detach();
                $page->delete();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to delete Page.");
            return back();
        }

        session()->flash("success", "Page Deleted.");
        return back();
    }
}
