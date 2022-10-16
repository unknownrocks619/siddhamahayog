<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function menu(Request $request, $slug)
    {
        $menu = Menu::where('slug', $request->slug)->firstOrFail();
        return view("frontend.menu." . $menu->menu_type, compact('menu'));
    }
}
