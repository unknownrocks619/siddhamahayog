<?php

namespace App\Http\Controllers\Admin\Website\Menus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Admin\MenuControllerRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    //
    public function index()
    {
        $menus = Menu::get();
        return view('admin.website.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.website.menu.add');
    }

    public function edit(Menu $menu)
    {
        return view('admin.website.menu.edit', compact('menu'));
    }

    public function update(MenuControllerRequest $request, Menu $menu)
    {
        $menu->menu_name = $request->menu_name;
        $menu->slug = Str::slug($request->menu_name, '-');
        $menu->description = $request->menu_description;
        $menu->menu_type = $request->menu_type;

        $menu->parent_menu = $request->parent_menu;
        $menu->menu_position = $request->menu_position;
        $menu->display_type = $request->display;

        $menu->meta_title = $request->meta_title;
        $menu->meta_keyword = $request->meta_keyword;
        $menu->meta_description = $request->meta_description;

        if ($request->hasFile("featured_image")) {
            $menu->menu_featured_image = asset(Storage::putFile("m-item", $request->file('featured_image')->path()));
        }

        $menu->active = ($request->active_status) ? true : false;

        try {
            $menu->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            $request->session()->flash('error', "Unable to update record.");
            return back()->withInput();
        }
        if (site_settings("cache")) {
            cache_website("menus", Menu::orderBy('sort_by', "ASC")->get());
        }

        $request->session()->flash('success', "Menu record updated.");
        return back();
    }

    public function store(MenuControllerRequest $request)
    {
        $menu = new Menu;

        $menu->menu_name = $request->menu_name;
        $menu->slug = ($request->slug) ? Str::slug($request->slug) : Str::slug($request->menu_name);
        $menu->menu_type = $request->menu_type;
        $menu->parent_menu = $request->parent_menu;

        if ($menu->where('slug', $menu->slug)->exists()) {
            $request->session()->flash('error', "Menu with same slug url already exists. Please use differnt menu name or different slug.");
            return back()->withInput();
        }

        // 
        if ($request->parent_menu) {
            $current_count =  $menu->where('parent_menu', $request->parent_menu)->count();
            // dd($current_count);
            $menu->sort_by = (!$current_count) ? 1 :  $current_count + 1;
        } else {
            $menu->sort_by = $menu->count() + 1;
        }

        $menu->menu_position = $request->menu_position;
        $menu->active = ($request->active_status) ? true : false;
        $menu->display_type = $request->display;

        $menu->meta_title = $request->meta_title;
        $menu->meta_keyword = $request->meta_keyword;
        $menu->meta_description = $request->meta_description;

        // now if featured image is updated.
        if ($request->hasFile("featured_image")) {
            // now let's upload and than 
            $menu->menu_featured_image = asset(Storage::putFile("m-item", $request->file('featured_image')->path()));
        }

        if ($request->hasFile('meta_image')) {
            $menu->meta_image = asset(Storage::putFile("m-item", $request->file('meta_image')->path()));
        }

        try {
            $menu->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to create New Record.");
            return back()->withInput();
        }


        if (site_settings("cache")) {
            cache_website("menus", Menu::orderBy('sort_by', "ASC")->get());
        }

        // now let's cache this settings as well.
        session()->flash('success', "New menu `{$menu->menu_name}` Item Created. ");
        return back();
    }

    public function delete(Request $request, Menu $menu)
    {

        try {
            $menu->delete();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('error', "Unable to delete selected Menu.");
            return back();
        }
        if (site_settings("cache")) {
            cache_website("menus", Menu::orderBy('sort_by', "ASC")->get());
        }
        $request->session()->flash('success', "Menu Deleted.");
        return back();
    }

    public function settings()
    {
        return view('admin.website.menu.settings');
    }

    public function edit_settings()
    {
    }

    public function update_settings()
    {
    }


    /**
     * 
     */

    public function reOrder(Request $request)
    {
        $request->validate([
            "ids" => "required|array",
            "ids.*" => "integer",
            "menu_id" => "required|integer"
        ]);


        foreach ($request->ids as $index => $id) {
            $menu = Menu::where('id', $id)->first();
            $menu->sort_by = $index + 1;
            $menu->update();
        }
    }

    public function reOrderSingle(Request $request, Menu $menu)
    {
        $menu->sort_by = $request->sort_by;
        $menu->saveQuietly();
        return back();
    }

    public function modulesOptions(Menu $menu)
    {
        return view('admin.website.menu.modules.' . $menu->menu_type . '.list', compact('menu'));
    }


    public function moduleAttach(Request $request, Menu $menu)
    {
        $relationship = $request->type;
        $menu->$relationship()->attach($request->link);

        session()->flash('success', "Module Attached to menu");
        return redirect()->route('admin.website.menus.admin_menu_list');
    }

    public function manageModule(Menu $menu)
    {
        // load by type.
        $category = ($menu->menu_type == "category") ? $menu->load('categories') : null;
        $courses = ($menu->menu_type == "course") ? $menu->load('courses') : null;
        $pages = ($menu->menu_type == "page") ? $menu->load("pages") : null;
        $posts = ($menu->menu_type == "post") ? $menu->load("posts") : null;

        return view("admin.website.menu.manage", compact("menu", "category", "courses", "pages", 'posts'));
    }

    public function moduleDeatch(Request $request, Menu $menu, $deatch_id)
    {
        $relationship = $request->type;
        try {
            $menu->$relationship()->detach($deatch_id);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            session()->flash("error", "Unable to unlink module.");
            return back();
        }

        session()->flash("success", "Module Removed from menu.");
        return back();
    }
}
