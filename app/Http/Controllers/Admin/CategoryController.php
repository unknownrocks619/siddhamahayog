<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryStoreRequest;
use App\Http\Requests\Admin\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //

    public function index()
    {
        // $categories = Category::with(["descendants"])->get();
        $categories = Category::get();

        return view("admin.category.index", compact("categories"));
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = new Category;
        $category->category_name = $request->category_name;
        $category->category_type = $request->category_type;
        $categories->slug = Str::slug($request->category_name, "-");
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        try {
            $category->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to create record." . $th->getMessage());

            return back()->withInput();
        }

        session()->flash('success', "Category Created.");

        return back();
    }

    public function edit(Category $category)
    {
        return view("admin.category.edit", compact("category"));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->category_type = $request->category_type;
        $category->slug = $request->slug;
        try {
            $category->update();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to update record. " . $th->getMessage());

            return back()->withInput();
        }

        session()->flash("success", "Category updated.");

        return back();
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to delete category." . $th->getMessage());

            return back();
        }

        session()->flash('success', "Category Deleted.");
        return back();
    }
}
