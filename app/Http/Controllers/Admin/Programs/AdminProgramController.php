<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Program;
use App\Models\ProgramBatch;
use App\Models\ProgramCourse;
use App\Models\ProgramSection;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class AdminProgramController extends Controller
{
    //

    public function program_list(Request $request, $type = null)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $programs = Program::with(["active_batch" => function ($query) {
                return $query->with(["batch"]);
            }]);

            if ($type) {
                $programs->where("program_type", "paid")->latest()->get();
            }

            $datatable = DataTables::of($programs)
                ->addIndexColumn()
                ->addColumn('program_name', function ($row) {
                    $program = $row->program_name;
                    $program .= "<br />";
                    if ($row->program_type == "paid") {
                        $program .= "<span class='text-success px-2'>PAID</span>";
                    } else {
                        $program .= "<span class='text-warning px-2'>" . strtoupper($row->program_type) . "</span>";
                    }
                    return $program;
                })
                ->addColumn('program_duration', function ($row) {
                    return ($row->program_duration) ? "Ongoing" : $row->program_duration;
                })
                ->addColumn('promote', function ($row) {
                    return "<a class='btn btn-success btn-sm' href='" . route('admin.program.live', [$row->id]) . "' data-toggle='modal' data-target='#addBatch'>Go Live</a>";
                })
                ->addColumn('batch', function ($row) {
                    if ($row->active_batch) {
                        return ($row->active_batch->batch->batch_name . "-" . $row->active_batch->batch->batch_year . "/   " . $row->active_batch->batch->batch_month);
                    } else {
                        return "<a href='" . route('admin.program.admin_program_add_batch_modal', [$row->id]) . "' data-toggle='modal' data-target='#addBatch'>Add Batch</a>";
                    }
                })
                ->addColumn('action', function ($row) {
                    $action = "<a href='" . route('admin.program.admin_program_detail', [$row->id]) . "' class='btn btn-primary btn-sm'>view detail</a>";
                    $action .= "<a href='" . route('admin.program.admin_program_edit', [$row->id]) . "' class='btn btn-info btn-sm'>Edit</a>";
                    $action .= "<a href='" . route('admin.program.admin_program_edit', [$row->id]) . "' class='btn btn-danger btn-sm'>Delete</a>";
                    return $action;
                })
                ->rawColumns(["program_name", "batch", "action", "promote"])
                ->make(true);
            return $datatable;
        }
        return view("admin.programs.index");
    }

    public function new_program($type = null)
    {
        return view("admin.programs.add", compact("type"));
    }

    public function edit_program(Program $program)
    {

        $program->promote = ($program->promote) ? "yes" : "no";
        if ($program->program_duration) {
            $start_date = explode("-", $program->program_duration);
            $program->program_duration_start = $start_date[0];
            $program->program_duration_end = (isset($start_date[1])) ? $start_date[1] : null;
        }
        unset(
            $program->created_at,
            $program->deleted_at,
            $program->updated_at,
            $program->program_duration,
            $program->zoom,
            $program->status
        );
        return view("admin.programs.edit", compact('program'));
    }

    public function add_batch_modal(Request $request, Program $program)
    {
        $batches = Batch::get();
        return view("admin.programs.modal.add_batch", compact("program", "batches"));
    }

    public function store_batch_program(Request $request, Program $program)
    {


        $program_batch = new ProgramBatch;
        $program_batch->program_id = $program->id;
        $program_batch->batch_id = $request->batch;
        $program_batch->active = true;

        // check if exists.
        $exists = ProgramBatch::where('program_id', $program->id)
            ->where('batch_id', $request->batch)
            ->exists();

        if ($exists) {
            session()->flash('error', "Program is already associated with Batch");
            return back();
        }
        $old_batch = ProgramBatch::where('program_id', $program->id)
            ->where('active', true)
            ->latest()
            ->first();
        if ($old_batch) {
            $old_batch->active = false;
        }

        try {
            DB::transaction(function () use ($old_batch, $program_batch) {
                if ($old_batch && $old_batch->isDirty()) {
                    $old_batch->save();
                }
                $program_batch->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Error: " . $th->getMessage());
            return back();
        }

        session()->flash("success", "Batch Added.");
        return back();
    }

    public function program_detail(Request $request, Program $program)
    {
        $sections = ProgramSection::where('program_id', $program->id);
        $students = ProgramStudent::with(["section", "batch", "student"])->where('program_id', $program->id)->lazy();
        return view("admin.programs.detail", compact("program", "sections", "students"));
    }

    public function goLiveCreate(Program $program)
    {
        $program->load(["sections"]);
        return view("admin.programs.live.index", compact("program"));
    }

    public function storeLive(Request $request, Program $program)
    {
        // lets go live.
    }
}
