<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data = [];
        if (Auth::check())
        {
            $page = "admin";
            $centerRecord = Center::get();
            $data["centers"] = $centerRecord;
        }
        return view($page.".centers.list",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function show(Center $center)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function edit(Center $center)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Center $center)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Center  $center
     * @return \Illuminate\Http\Response
     */
    public function destroy(Center $center)
    {
        //
    }

    public function new_center_form()
    {
        if (Auth::check()){
            $page = "admin";
        }
        return view ($page.".centers.forms");
    }

    public function create_center(Request $request)
    {
        if(Auth::check())
        {
            $db_post = $request->post();
            $db_post['created_by_user'] = Auth::user()->id;

            $centerRecord = Center::create($db_post);

            if ($centerRecord->id)
            {
                return redirect()->route('centers.center_list')->with('success','New Center was created successfully.');
            }
        }
    }
}
