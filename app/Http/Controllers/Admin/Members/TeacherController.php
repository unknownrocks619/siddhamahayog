<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //
    public function index()
    {
        if (request()->ajax()) {
        }

        return view('admin.members.teachers-list');
    }
}
