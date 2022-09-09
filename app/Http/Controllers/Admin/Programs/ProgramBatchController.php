<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramBatch;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramBatchController extends Controller
{
    //

    public function index(Program $program)
    {
        //
        $program->load(["active_batch"]);
        $batches = ProgramBatch::with(["batch"])->where('program_id', $program->id)->latest()->get();
        $all_batches = Batch::get();
        return view('admin.programs.batch.list', compact("batches", "program", "all_batches"));
    }

    public function updateActive(Program $program, ProgramBatch $ProgramBatch)
    {
        // check if this program is active or not.
        if ($ProgramBatch->active) {
            return back();
        }

        $ProgramBatch->active = true;
        try {
            DB::transaction(function () use ($ProgramBatch, $program) {
                $program->batches()->update(["active" => false]);
                $ProgramBatch->save();
            });
        } catch (\Throwable $th) {
            session()->flash("error", "Error: " . $th->getMessage());
            return back();
        }

        session()->flash("success", "Default Batch Updated.");
        return back();
    }

    public function storeBatch(Request $request, Program $program)
    {

        if ($program->batches()->where('batch_id', $request->batch)->exists()) {
            session()->flash("success", "Batch Already added.");
            return back();
        }
        $program_batch = new ProgramBatch;
        $program_batch->batch_id = $request->batch;
        $program_batch->active = ($request->default) ? true : false;
        $program_batch->program_id = $program->id;
        try {
            $program_batch->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Error: " . $th->getMessage());
            return back()->withInput();
        }

        session()->flash("success", "New Batch Added.");
        return back();
    }

    public function batchStudent(Request $request, Program $program, Batch $batch)
    {

        //
        $all_students = ProgramStudent::with(["section", "batch", 'student'])->where('program_id', $program->id)->where('batch_id', $batch->id)->get();
        return view("admin.programs.batch.batch-student", compact("all_students", "batch", "program"));
    }

    public function changeBatch(Request $request, Program $program, Member $member)
    {
        $program = $program->load(["batches" => function ($query) {
            return $query->with(["batch"]);
        }]);
        return view("admin.programs.batch.change-batch", compact("program", "member"));
    }

    public function updateBatch(Request $request, Program $program, Member $member)
    {
        $programBatch = ProgramStudent::where('program_id', $program->id)
            ->where('student_id', $member->id)
            ->first();
        $programBatch->batch_id = $request->batch;

        try {
            $programBatch->save();
        } catch (\Throwable $th) {
            session()->flash('error', "Error: " . $th->getMessage());
            return redirect()->route('admin.program.batches.admin_batch_list', [$program->id]);
        }

        session()->flash('success', "Student data updated.");
        return redirect()->route('admin.program.batches.admin_batch_list', [$program->id]);
    }
}
