<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use DataTables;

class AdminPaidProgramController extends Controller
{
    //
    public function index(Request $request) {

        if ($request->ajax()) {
            $programs = Program::where("program_type","paid")->with(["active_batch"=>function($query){
                return $query->with(["batch"]);
            }])->latest()->get();

            $datatable = DataTables::of($programs)
                        ->addIndexColumn()
                        ->addColumn('program_name', function($row){
                            $program = $row->program_name;
                            $program .= "<br />";
                            if ($row->program_type == "paid") {
                                $program .= "<span class='text-success px-2'>PAID</span>";
                            } else {
                                $program .= "<span class='text-warning px-2'>".strtoupper($row->program_type)."</span>";
                            }
                            return $program;
                        })
                        ->addColumn('program_duration', function($row) {
                            return ($row->program_duration) ? "Ongoing" : $row->program_duration;
                        })
                        ->addColumn('promote', function($row) {
                            return ($row->promote) ? "Allowed" : "Not-Allowed";
                        })
                        ->addColumn('batch',function($row){
                            if ($row->active_batch) {
                                return ($row->active_batch->batch->batch_name);
                            } else {
                                return "<a href='#'>Add Batch</a>";
                            }
                        })
                        ->addColumn('action', function ($row) {
                            $action = "<a href='". route('admin.program.admin_program_edit',[$row->id]) ."' class='btn btn-primary btn-sm'>view detail</a>";
                            $action .= "<a href='". route('admin.program.admin_program_edit',[$row->id]) ."' class='btn btn-info btn-sm'>Edit</a>";
                            $action .= "<a href='". route('admin.program.admin_program_edit',[$row->id]) ."' class='btn btn-danger btn-sm'>Delete</a>";
                            return $action;                        
                        })
                        ->rawColumns(["program_name","batch","action"])
                        ->make(true);
            return $datatable;  
        }
        return view('admin.programs.paid.index');
    }
}
