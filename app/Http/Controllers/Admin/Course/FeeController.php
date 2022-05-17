<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Models\ProgramCourseFee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            "program" => "required",
            "admission_fee" => "required",
            "monthly_fee" => "required"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgramCourseFee  $programCourseFee
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramCourseFee $programCourseFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramCourseFee  $programCourseFee
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramCourseFee $programCourseFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramCourseFee  $programCourseFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramCourseFee $programCourseFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramCourseFee  $programCourseFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramCourseFee $programCourseFee)
    {
        //
    }
}
