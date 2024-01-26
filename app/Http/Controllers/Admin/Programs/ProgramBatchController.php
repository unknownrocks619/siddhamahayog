<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Admin\Datatables\ProgramDataTablesController;
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

    public function index(Request $request,Program $program,$current_tab=null)
    {
        if ($request->ajax() ) {
            $members = ProgramStudent::all_program_student($program,request()->member,30);
            $programBatch = ProgramBatch::where('program_id',$program->getKey())
                                            ->where('batch_id',$request->get('batch'))
                                            ->first();
            return view('admin.batch.partials.program.students',['members' => $members,'programBatch' => $programBatch,'program' => $program]);
        }

        $program->load(["active_batch"]);
        $batches = ProgramBatch::with(["batch"])->where('program_id', $program->id)->latest()->get();
        $all_batches = Batch::get();
        return view('admin.programs.batch.list', compact("batches", "program", "all_batches",'current_tab'));
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
        if ($request->ajax()  ) {

            $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';

            return (new ProgramDataTablesController($searchTerm))
                        ->setSearchTerm($searchTerm)
                        ->setRawColumns(['roll_number',"full_name"])
                        ->getBatchStudent($program,$batch);

        }

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

    public function deleteBatch(Program $program, Batch $batch) {

        // first check if there are students in the batch.
        $programBatch = ProgramBatch::where('batch_id',$batch->getKey())
                                        ->where('program_id', $program->getKey())
                                        ->first();
        if ( ! $programBatch ) {
            return $this->json(false,'Batch Not assigned to selected program.');
        }

        // get last batch for this program.
        $lastBatch = ProgramBatch::where('program_id',$program->getKey())
                                    ->where('id','!=',$programBatch->getKey())
                                    ->where('active',true)
                                    ->first();

        if ( ! $lastBatch ) {
            return $this->json(false,'Unable to remove batch. Program needs to have atleast one batch assigned.');
        }

        $lastBatchInfo = Batch::where('id',$lastBatch->batch_id)->first();
        try {
            DB::transaction(function() use ($programBatch,$lastBatch,$program) {
                ProgramStudent::where('program_id',$program->getKey())
                    ->where('batch_id',$programBatch->getKey())
                    ->update(['batch_id'=>$lastBatch->getKey()]);

                $programBatch->delete();
            });
        } catch (\Exception $error) {
            return $this->json(false,'Error: Unable to complete your request.',['error' => $error->getMessage()]);
        }

        return $this->json(true,'Batch Link Removed.','redirect',['location' => route('admin.program.batches.admin_batch_list',['program' => $program,'current_tab' => str($lastBatchInfo->slug)])]);
    }

    public function assignBatch(Request $request, Program $program) {
        $request->validate([
            'batch' => 'required'
        ]);

        $batch = Batch::where('id',$request->post('batch'))->first();

        // check if batch is already assigned.

        $programBatch = ProgramBatch::where('batch_id',$batch->getKey())->where('program_id',$program->getKey())->exists();

        if ( $programBatch ) {
            return $this->json(false,'Batch Already Assigned to program.');
        }

        $programBatch = new ProgramBatch();
        $programBatch->fill([
            'program_id' => $program->getKey(),
            'batch_id'  => $batch->getKey(),
            'active'    => true
        ]);

        if ( ! $programBatch->save() ) {
            return $this->json(false,'Unable to link batch information.');
        }

        return $this->json(true,'Batch Linked.','redirect',['location' => route('admin.program.batches.admin_batch_list',['program' => $program,'current_tab' => $batch->slug])]);

    }
}
