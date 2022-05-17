<?php

namespace App\Http\Controllers\Admin\Batch;

use App\Http\Controllers\Controller;
use App\Http\Requests\BatchRequest;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use DataTables;

class AdminBatchController extends Controller
{
    //

    public function batch(Request $request) {

        if ( $request->ajax() && $request->wantsJson()) {
            $batches = Batch::latest()->withCount(['batch_program'])->get();
            $datatable = Datatables::of($batches)
                                ->addIndexColumn()
                                ->addColumn('name',function($row){
                                    return $row->batch_name;
                                })
                                ->addColumn('batch_year',function($row) {
                                    return $row->batch_year;
                                })
                                ->addColumn('batch_month', function($row) {
                                    return $row->batch_month;
                                })
                                ->addColumn("total_used", function($row) {
                                    return "Total Used In: ". $row->batch_program_count;
                                })
                                ->addColumn('action', function( $row ) {
                                    $link = "<a href='".route('admin.batch.admin_edit_batch',$row->id)."' class='btn btn-info btn-sm'>";
                                        $link .= "<i class='zmdi zmdi-edit'></i>";
                                        $link .= "&nbsp;";
                                        $link .= "Edit";
                                    $link .= "</a>";
                                    $link .= " <form method='post' style='display:inline' action='".route('admin.batch.admin_delete_batch',[$row->id])."'>";
                                        $link .= csrf_field();
                                        $link .= "<button type='submit'  class='btn btn-danger btn-sm'>";
                                        $link .= "<i class='zmdi zmdi-delete'></i>";
                                        $link .= "&nbsp;";
                                        $link .= "Delete";
                                        $link .= "</button>";
                                    $link .= "</form>";
                                    return $link;

                                })
                                ->make(true);
            return $datatable;
        }
        $batches = Batch::get();
        return view("admin.batches.index",compact("batches"));
    }

    public function create_batch() {
        return view('admin.batches.create-batch');
    }

    public function store_batch(BatchRequest $request) {
        $batch = new Batch;
        $batch->batch_name = $request->batch_name;
        $batch->slug = Str::slug($batch->batch_name,"-");
        $batch->batch_year = $request->year;
        $batch->batch_month = $request->month;

        // try slug.

        $test_batch = Batch::where("slug",$batch->slug)->first();

        if ( $test_batch ) {
            $request->session()->flash("error","Batch with Same Name exists.");
            return back()->withInput();
        }

        try {
            $batch->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash("error","Warning: ". $th->getMessage());
            return back()->withInput();
        } catch (\Error $er) {
            $request->session()->flash("error","Warning: ". $th->getMessage());
            return back()->withInput();
        }

        $request->session()->flash("success","New batch created.");
        return back();
    }

    public function edit_batch(Batch $batch) {
        return view('admin.batches.edit-batch',compact("batch"));
    }

    public function update_batch(BatchRequest $request, Batch $batch) {
        $batch->batch_name = $request->batch_name;
        $batch->slug = $request->slug;
        $batch->batch_year = $request->year;
        $batch->batch_month = $request->month;

        try {
            $batch->save();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('error',"Warning: ". $th->getMessage());
            return back()->withInput();
        } catch (\Error $er) {
            $request->session()->flash("error","Error: ". $th->getMessage());
            return back()->withInput();
        }

        $request->session()->flash('success',"Information updated.");
        return back();
    }

    public function batch_program() {

    }

    public function delete_batch(Request $request, Batch $batch) {
        if ( $batch->batch_program->count() ) {
            $request->session()->flash("error","Batch is assigned to program. Please Remove Assigned program first.");
            return back();
        }

        try {
            $batch->delete();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('error',"Warning: ". $th->getMessage());
            return back();
        } catch (\Error $er) {
            $request->session()->flash('error',"Error: " . $th->getMessage());
            return back();
        }

        $request->session()->flash("success","Batch Deleted.");
        return back();
    }

    public function member_list_with_batch_program() {

    }
    
}
