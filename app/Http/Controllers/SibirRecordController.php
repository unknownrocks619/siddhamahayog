<?php

namespace App\Http\Controllers;

use App\Models\SibirRecord;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SibirRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sibirs = SibirRecord::get();
        return view('admi.sibirs.index',compact('sibirs'));
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
     * @param  \App\Models\SibirRecord  $sibirRecord
     * @return \Illuminate\Http\Response
     */
    public function show(SibirRecord $sibirRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SibirRecord  $sibirRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(SibirRecord $sibirRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SibirRecord  $sibirRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SibirRecord $sibirRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SibirRecord  $sibirRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(SibirRecord $sibirRecord)
    {
        //
    }
}
