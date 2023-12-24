<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\AdminCourseFeeRequest;
use App\Models\Batch;
use App\Models\Live;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramBatch;
use App\Models\ProgramCourse;
use App\Models\ProgramCourseFee;
use App\Models\ProgramSection;
use App\Models\ProgramStudent;
use App\Models\Ramdas;
use App\Models\ZoomAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AdminProgramController extends Controller
{
    //

    public function program_list(Request $request, $type = null)
    {

        if ($request->ajax() && $request->wantsJson()) {

            $programs = Program::with(["defaultBatch",
                "liveProgram" => function ($query) {
                return $query->with(["sections"]);
            },'students','sections' => function ($query) {
                $query->withCount('programStudents');
            }]);

            if ($type) {
                $programs->where("program_type", $type)->latest()->get();
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
                ->addColumn('sections', function ($row) {
                    $sectionHTML = '';
                    foreach ($row->sections ?? [] as $section) {

                        if ($section->default) {
                            $sectionHTML .= '<span class="mx-1 my-1 btn btn-label-danger">'.$section->section_name .':{'.$section->program_students_count.'}</span>';
                            continue;
                        }
                        $sectionHTML .= '<span class="mx-1 my-1 btn btn-label-primary">'.$section->section_name .':{'.$section->program_students_count.'}</span>';
                    }
                    return $sectionHTML;
                })
                ->addColumn('total_student', function ($row) {
                    $totalStudent =  $row->students?->count() ?? 0;

                    if ( ! $totalStudent ) {
                        return '<span class="btn-label-danger px-2 py-1">0</span>';
                    }
                    return '<span class="btn-label-success px-2 py-1">'.$totalStudent.'</span>';
                })
                ->addColumn('promote', function ($row) {
                    if ($row->liveProgram->count()) {
                        $live_session = "";
                        foreach ($row->liveProgram as $live_program) {
                            $live_session .= "<form method='post' action='" . route('admin.program.live_program.end', [$live_program->id]) . "'>";
                            $live_session .= csrf_field();
                            $live_session .= "<button type='submit' class='btn btn-danger btn-sm clickable'>";
                            if (!$live_program->section_id) {
                                $live_session .= "End Live Session";
                            } else {
                                $live_session .= "End " . $live_program->sections->section_name . " Program";
                            }
                            //
                            $live_session .= "</button>";
                            $live_session .= "</form>";
                        }


                        $live_session .= "<br />";
                        $live_session .= "<a href='" . route('admin.program.live_program.merge.view', [$row->id, $live_program->id]) . "' data-toggle='modal' data-target='#addBatch'  class='btn btn-info btn-sm'>";
                        $live_session .= "Merge";
                        $live_session .= "</a>";
                        $live_session .= "<a class='btn btn-success btn-sm' href='" . route('admin.program.live', [$row->id]) . "' data-toggle='modal' data-target='#addBatch'>Go Live</a>";
                        return $live_session;
                    }
                    return "<a class='btn btn-success btn-sm' href='" . route('admin.program.live', [$row->id]) . "' data-toggle='modal' data-target='#addBatch'>Go Live</a>";
                })
                ->addColumn('batch', function ($row) {
                    if ($row->defaultBatch) {
                        return ($row->defaultBatch->batch_name . "-" . $row->defaultBatch->batch_year . "/   " . $row->defaultBatch->batch_month);
                    } else {
                        return "<button data-action='" . route('admin.modal.display', ['view' => 'programs.batch.new','program' => $row->getKey(),'callback' => 'reload'] ) . "' data-bs-toggle='modal' data-bs-target='#newBatch' class='btn btn-link ajax-modal'>Add Batch</button>";
                    }
                })
                ->addColumn('action', function ($row) {
                    $action = "<a href='" . route('admin.program.admin_program_detail', [$row->id]) . "' class='btn btn-primary btn-sm'><i class='fas fa-eye me-1'></i></a>";
                    $action .= "<a href='" . route('admin.program.admin_program_edit', [$row->id]) . "' class='btn btn-info btn-sm mx-1'><i class='fas fa-pencil'></i></a>";
                    $action .= "<a href='" . route('admin.program.admin_program_edit', [$row->id]) . "' class='btn btn-danger btn-sm'><i class='fas fa-trash'></a>";
                    return $action;
                })
                ->rawColumns(["program_name", "batch", "action", "promote","total_student",'sections'])
                ->make(true);
            return $datatable;
        }
        return view("admin.programs.index");
    }

    public function new_program(Request $request, $type = null)
    {
        if ($request->post() ) {

            $request->validate(['program_name' => 'required']);

            $program = new Program();
            $program->fill([
                'program_name' => $request->post('program_name'),
                'slug' => str($request->post('program_name'))->slug('-')->value(),
                'program_type' => $request->post('program_type'),
                'admission_fee' => $request->post('admission_fee'),
                'monthly_fee'   => $request->post('monthly_fee'),
                'program_duration'  => null,
                'program_access' => null,
                'description' => $request->post('description'),
                'promote' => true,
                'overdue_allowed' => $request->post('overdue_allowed'),
                'batch' => 0,
                'zoom' => true,
                'status' => false,

            ]);

            if ( $request->post('start_date') && $request->post('end_date')) {
                $carbonStartDate = Carbon::createFromFormat('Y-m-d',$request->post('program_start_date'));
                $carbonEndDate = Carbon::createFromFormat('Y-m-d',$request->post('program_end_date'));
                $program_diff = $carbonEndDate->diffInDays($carbonEndDate);
                $program->program_duration = $program_diff;
            }

            if ( ! $program->save() ) {
                return $this->json(false,'Unable to create new Program.');
            }

            return $this->json(true, 'New Program created.','redirect',['location' => route('admin.program.admin_program_edit',['program' => $program])]);
        }


        return view("admin.programs.add", compact("type"));
    }

    public function edit_program(Request $request, Program $program)
    {
        if ( $request->post() ) {
            $program->fill([
                'program_name'  => $request->post('program_name'),
                'program_type'  => $request->post('program_type'),
                'program_start_date'    => $request->post('program_start_date'),
                'program_end_date'  => $request->post('program_end_date'),
                'monthly_fee'   => $request->post('monthly_fee'),
                'admission_fee' => $request->post('admission_fee'),
                'status'    => $request->post('status'),
                'batch' => $request->post('batch'),
                'overdue_allowed'   => $request->post('overdue_allowed'),
                'description'   => $request->post('description'),
                'zoom'  => $request->post('zoom'),
            ]);

            $program->save();

            // update batch

            if ($request->post('batch') ) {

                $programBatch = ProgramBatch::where('batch_id',$request->post('batch'))
                                            ->where('program_id',$program->getKey())
                                            ->first();
                if (! $programBatch ) {

                    $programBatch = new ProgramBatch();
                    $programBatch->fill([
                        'program_id' => $program->getKey(),
                        'batch_id'  => $request->post('batch')
                    ]);
                }

                $programBatch->active = true;
                $programBatch->save();

            }

            if ( $request->post('section') ) {
                $programSection = ProgramSection::where('id',$request->post('section'))->first();
                $defaultProgramSection = ProgramSection::where('program_id',$program->getKey())
                                                        ->where('default',true)
                                                        ->first();
                if ( $defaultProgramSection ) {
                    $defaultProgramSection->default = false;
                    $defaultProgramSection->save();
                }

                $programSection->default = true;
                $programSection->save();
            }

            return $this->json(true,'Program Information Updated.');
        }

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

    public function zoom_live_modal(Program $program)
    {
        return view('admin.programs.modal.go-live', compact('program'));
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

    /**
     * Program Detail
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function program_detail(Request $request, Program $program)
    {

        if ($request->ajax() && $request->wantsJson()) {

            $datatable = DataTables::of($program->programStudentEnrolments())
                ->addIndexColumn()
                ->addColumn('roll_number', function ($row) {

                    if ( ! $row->roll_number) {
                        return '<span class="label label-bg-dark px-1"><a href="" class="text-info"><i class="fas fa-plus"></i> Add Roll number</a></span>';
                    }

                    return '<span class="label label-info px-1">'.$row->roll_number.'</span>';

                })
                ->addColumn('full_name', function ($row) {
                    return "<a href='route()'>".$row->full_name."</a>";
                })
                ->addColumn('phone_number', function ($row) {
                    return $row->phone_number ?? 'N/A';
                })
                ->addColumn('email', function ($row) {
                    return $row->email ?? 'N/A';
                })
                ->addColumn('total_payment', function ($row) {
                    if ( ! $row->member_payment ) {
                        return '<span class="badge bg-label-danger">'.default_currency(0.0).'</span>';
                    }

                    if ($row->scholarID) {
                        return '<span class="badge bg-label-info"><b>Scholarshp</b><br />'.$row->remarks.'</span>';
                    }

                    return '<span class="badge bg-label-primary">'.default_currency($row->member_payment).'</span>';
                })
                ->addColumn('batch', function ($row) {
                    return $row->batch_name ?? 'Batch N/A';
                })
                ->addColumn('section', function ($row) {
                   return $row->section_name ?? 'Section N/A';
                })
                ->addColumn('enrolled_date', function($row) {
                   return date('Y-m-d',strtotime($row->enrolled_date));
                })
                ->addColumn('action', function ($row) {
                    $action ='';
                    return $action;
                })
                ->rawColumns(["total_payment", "action", "roll_number",'full_name'])
                ->make(true);
            return $datatable;
        }

        $sections = ProgramSection::where('program_id', $program->id)->get();

        $students = ProgramStudent::all_program_student($program);
        $paymentDetail = ProgramStudent::studentPaymentDetail('admission_fee', array_keys(Arr::keyBy($students, 'user_id')));
        if ($program->program_type != 'open') {

        }

        return view("admin.programs.detail", compact("program", "sections", "students", "paymentDetail"));
    }

    public function goLiveCreate(Program $program)
    {
        if (!request()->ajax()) {
            return response(['message' => 'Bearer token missing.']);
        }
        $program->load(["sections"]);
        return view("admin.programs.live.index", compact("program"));
        abort(403);
    }

    public function storeLive(Request $request, Program $program)
    {

        // check if program is already live or not.
        $liveProgram = Live::where('program_id', $program->id)->where('section_id', $request->section)->where('live', true)->exists();
        if ($liveProgram) {
            session()->flash("error", "Session is already active. Please end current session or re-join the session.");
            return redirect()->route('admin.program.admin_program_list');
        }

        $liveProgram = new Live;
        $liveProgram->live = true;
        $liveProgram->program_id = $program->id;
        $liveProgram->section_id = ($request->section) ? $request->section : null;
        $liveProgram->zoom_account_id = $request->zoom_account;
        $domain = str_shuffle('siddhamahayog') . ".org";


        $members = Member::select(['email'])->where('role_id', 1)
            ->orWhere('role_id', 11)
            ->get();

        $cohost = "";
        if ($members) {

            $emails = [];
            foreach ($members as $member) {
                $email_prefix = Str::before($member->email, "@");
                $email = $email_prefix . "@" . $domain;
                $emails[] = $email;
            }
            $cohost = implode(";", $emails);
        }

        // now let's retrieve zoom account detail.
        $zoom_account_detail = ZoomAccount::find($request->zoom_account);
//         dd(zoom_meeting_details(82527372739));
        $meeting = create_zoom_meeting($zoom_account_detail, $program->program_name, $domain);
        if (!$meeting || isset($meeting->code)) {
            // dd("unable to create meeting");
            session()->flash('error', "Unable to create zoom meeting at the moment.");
            return redirect()->route('admin.program.admin_program_list');
        }

        $liveProgram->domain = $domain;
        $liveProgram->meeting_id = $meeting['id'];
        $liveProgram->admin_start_url = $meeting['start_url'];
        $liveProgram->join_url = $meeting['join_url'];

        try {
            $liveProgram->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        return redirect()->to($liveProgram->admin_start_url);


        // create zoom meeting id.

    }

    public function endLiveSession(Live $live)
    {

        $live->live = false;
        $program_message = $live->program->program_name;

        if ($live->section_id) {
            $program_message .= " - " . $live->programSection->section_name;
        }
        $program_message .= " session ended.";
        try {
            $live->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Error: " . $th->getMessage());
            return back();
        }

        session()->flash('success', $program_message);
        return back();
    }

    /**
     * Merge two different section together.However you
     * cannot merge different program
     */
    public function mergeSessionView(Program $program, Live $live)
    {
        return view("admin.programs.modal.merge-session", compact("program", 'live'));
    }

    public function mergeSessionStore(Request $request, Program $program, Live $live)
    {
        $merge = ($live->merge) ?  array($live->merge) : [];
        $section = ProgramSection::find($request->merge_with);
        $merge[$request->merge_with] = ["id" => $request->merge_with, "name" => $section->section_name];
        $live->merge = $merge;

        try {
            $live->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Error:" . $th->getMessage());
            return redirect()->route('admin.program.admin_program_list');
        }
        session()->flash('success', "Session has been merged.");
        return redirect()->route('admin.program.admin_program_list');
    }

    public function rejoinSession(Live $live)
    {
        if (!$live->live) {
            session()->flash("error", "Program already closed.");
            return back();
        }

        return redirect()->to($live->admin_start_url);
    }

    public function liveProgram()
    {
        $lives = Live::with(['zoomAccount', "program", 'programSection'])->where("live", true)->get();
        return view('admin.programs.live.list', compact('lives'));
    }

    public function ramdasList(Live $live)
    {
        $ramdas = Ramdas::where('meeting_id', $live->meeting_id)->get();
        return view('admin.programs.live.modal.list', compact('live', 'ramdas'));
    }




    public function programBatchAndSectionModal(Program $program)
    {
        $program->load(['batches' => function ($query) {
            return $query->with(['batch']);
        }, 'sections']);
        return view('admin.programs.modal.program_batch_and_section_modal', compact('program'));
    }
}
