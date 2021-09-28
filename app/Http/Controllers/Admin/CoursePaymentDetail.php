<?php

namespace App\Http\Controllers\Admin;

use App\Models\EventFund;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoursePaymentDetail extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax() ) {
            $get_request_detail = EventFund::where("sibir_record_id",$request->sibir_reord)->latest()->get();
            return response(["success"=>true,"message","Record Retrieved.","data"->$get_request_detail]);
        }
        return view("admin.finance.course");
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
     * @param  \App\Models\EventFund  $eventFund
     * @return \Illuminate\Http\Response
     */
    public function show(EventFund $eventFund)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventFund  $eventFund
     * @return \Illuminate\Http\Response
     */
    public function edit(EventFund $eventFund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventFund  $eventFund
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventFund $eventFund)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventFund  $eventFund
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventFund $eventFund)
    {
        //
    }
}
