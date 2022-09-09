<?php

namespace App\Http\Controllers\Dharmashala;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DharmashalaController extends Controller
{
    //
    public function index()
    {
        return view("frontend.user.dharmashala.index");
    }

    public function create()
    {
        return view("frontend.user.dharmashala.create");
    }

    public function show()
    {
    }
}
