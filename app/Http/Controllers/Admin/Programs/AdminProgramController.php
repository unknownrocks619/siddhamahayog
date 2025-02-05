<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Classes\Helpers\Roles\Rule;
use App\Http\Controllers\Admin\Datatables\ProgramDataTablesController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Program\AdminCourseFeeRequest;
use App\Models\Batch;
use App\Models\Centers;
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

            return (new ProgramDataTablesController())->programList($request, $type);
            // return $datatable;
        }
        return view("admin.programs.index");
    }

    public function new_program(Request $request, $type = null)
    {

        if (!adminUser()->role()->isSuperAdmin() && !adminUser()->role()->isAdmin()) {
            abort(401);
        }

        if ($request->post()) {

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

            if ($request->post('start_date') && $request->post('end_date')) {
                $carbonStartDate = Carbon::createFromFormat('Y-m-d', $request->post('program_start_date'));
                $carbonEndDate = Carbon::createFromFormat('Y-m-d', $request->post('program_end_date'));
                $program_diff = $carbonEndDate->diffInDays($carbonEndDate);
                $program->program_duration = $program_diff;
            }

            if (!$program->save()) {
                return $this->json(false, 'Unable to create new Program.');
            }

            return $this->json(true, 'New Program created.', 'redirect', ['location' => route('admin.program.admin_program_edit', ['program' => $program])]);
        }


        return view("admin.programs.add", compact("type"));
    }

    public function edit_program(Request $request, Program $program)
    {
        if ($request->post()) {
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

            if ($request->post('batch')) {

                $programBatch = ProgramBatch::where('batch_id', $request->post('batch'))
                    ->where('program_id', $program->getKey())
                    ->first();
                if (!$programBatch) {

                    $programBatch = new ProgramBatch();
                    $programBatch->fill([
                        'program_id' => $program->getKey(),
                        'batch_id'  => $request->post('batch')
                    ]);
                }

                $programBatch->active = true;
                $programBatch->save();
            }

            if ($request->post('section')) {
                $programSection = ProgramSection::where('id', $request->post('section'))->first();
                $defaultProgramSection = ProgramSection::where('program_id', $program->getKey())
                    ->where('default', true)
                    ->first();
                if ($defaultProgramSection) {
                    $defaultProgramSection->default = false;
                    $defaultProgramSection->save();
                }

                $programSection->default = true;
                $programSection->save();
            }

            return $this->json(true, 'Program Information Updated.');
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

            $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';

            $datatable = DataTables::of($program->programStudentEnrolments($searchTerm))
                ->addIndexColumn()
                ->addColumn('roll_number', function ($row) use ($program) {

                    if ($program->getKey() == 5) {

                        if (!$row->total_counter) {
                            return '<span class="label label-bg-dark px-1"> 0 </span>';
                        }

                        return '<span class="label label-info px-1">' . $row->total_counter . '</span>';
                    }

                    if (!$row->roll_number) {
                        if (!adminUser()->role()->isSuperAdmin() || !adminUser()->role()->isAdmin()) {
                            return '<span class="label label-bg-dark px-1"> -</span>';
                        }
                        return '<span class="label label-bg-dark px-1"><a href="" class="text-info"><i class="fas fa-plus"></i> Add Roll number</a></span>';
                    }

                    return '<span class="label label-info px-1">' . $row->roll_number . '</span>';
                })
                ->addColumn('full_name', function ($row) {
                    return htmlspecialchars(strip_tags($row->full_name));
                })
                ->addColumn('phone_number', function ($row) {
                    return $row->phone_number ?? 'N/A';
                })
                ->addColumn('email', function ($row) {
                    $emailStr = str($row->email);

                    if ($emailStr->contains('random_email_')) {
                        return 'N/A';
                    }

                    return strip_tags($row->email) ?? 'N/A';
                })
                ->addColumn('total_payment', function ($row) {
                    if (!$row->member_payment) {
                        return '<span class="badge bg-label-danger">' . default_currency(0.0) . '</span>';
                    }

                    if ($row->scholarID) {
                        return '<span class="badge bg-label-info"><b>Scholarshp</b><br />' . $row->remarks . '</span>';
                    }

                    return '<span class="badge bg-label-primary">' . default_currency($row->member_payment) . '</span>';
                })
                ->addColumn('batch', function ($row) {
                    return $row->batch_name ?? 'Batch N/A';
                })
                ->addColumn('section', function ($row) {
                    return $row->section_name ?? 'Section N/A';
                })
                ->addColumn('enrolled_date', function ($row) {
                    return date('Y-m-d', strtotime($row->enrolled_date));
                })
                ->addColumn('country', function ($row) {
                    if (!$row->member_country &&  !$row->country_name) {
                        return 'N/A';
                    }
                    if ($row->member_country && !(int) $row->member_country) {
                        return $row->member_country;
                    }

                    return $row->country_name;
                })
                ->addColumn('full_address', function ($row) {
                    if (!$row->address) {
                        return 'N/A';
                    }

                    $addressDecode = json_decode($row->address);
                    if (isset($addressDecode->street_address)) {
                        return strip_tags($addressDecode->street_address);
                    }

                    if ($row->personal_detail) {
                        $detailDecode = json_decode($row->personal_detail);

                        if (isset($detailDecode->street_address)) {
                            return strip_tags($detailDecode->street_address);
                        }
                    }

                    return 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $action = '<a href="' . route('admin.members.show', ['member' => $row->member_id, '_ref' => 'program', '_refID' => $row->program_id]) . '"><i class="fas fa-eye"></i></a>';
                    return $action;
                })
                ->rawColumns(["total_payment", "action", "roll_number"])
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
            return $this->returnResponse(false, 'Session is already active. Please end current session or re-join the session.', null, [], 200, route('admin.program.admin_program_list'));
            //            session()->flash("error", "Session is already active. Please end current session or re-join the session.");
            //            return redirect()->route('admin.program.admin_program_list');
        }

        $liveProgram = new Live;
        $liveProgram->live = true;
        $liveProgram->program_id = $program->id;
        $liveProgram->section_id = ($request->section) ? $request->section : null;
        $liveProgram->zoom_account_id = $request->zoom_account;
        $liveProgram->started_by = adminUser()->getKey();
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

        $zoom_account_detail = ZoomAccount::find($request->zoom_account);
        $meeting = create_zoom_meeting($zoom_account_detail, $program->program_name, $domain);

        if (!$meeting || isset($meeting->code)) {
            return $this->returnResponse(false, 'Unable to create Zoom Meeting at the moment', null, [], 200, route('admin.program.admin_program_list'));
            //            // dd("unable to create meeting");
            //            session()->flash('error', "Unable to create zoom meeting at the moment.");
            //            return redirect()->route('admin.program.admin_program_list');
        }

        $liveProgram->domain = $domain;
        $liveProgram->meeting_id = $meeting['id'];
        $liveProgram->admin_start_url = $meeting['start_url'];
        $liveProgram->join_url = $meeting['join_url'];

        try {
            $liveProgram->save();
        } catch (\Throwable $th) {
            return $this->returnResponse(false, 'Error: ' . $th->getMessage(), null, [], 200, route('admin.program.admin_program_list'));
            //throw $th;
            dd($th->getMessage());
        }
        return $this->returnResponse(true, 'Meeting Started. Please wait redirecting you to zoom portal.', 'redirectTab', ['location' => $liveProgram->admin_start_url, 'reload' => true], 200, $liveProgram->admin_start_url);
        //        return redirect()->to($liveProgram->admin_start_url);


        // create zoom meeting id.

    }

    public function endLiveSession(Live $live)
    {
        $live->live = false;
        $live->closed_by = adminUser()->getKey();
        $program_message = $live->program->program_name;

        if ($live->section_id) {
            $program_message .= " - " . $live->programSection->section_name;
        }

        $program_message .= " session ended.";

        try {
            $live->save();
        } catch (\Throwable $th) {
            return $this->returnResponse(false, 'Error : ' . $th->getMessage(), null, [], 200, url()->previous());
            //throw $th;
            session()->flash('error', "Error: " . $th->getMessage());
            return back();
        }

        return $this->returnResponse(true, $program_message, 'reload', [], 200, url()->previous());
    }

    /**
     * Merge two different section together.However you
     * cannot merge different program
     */
    public function mergeSessionView(Program $program, Live $live)
    {
        return view("admin.programs.modal.merge-session", compact("program", 'live'));
    }

    public function mergeSessionStore(Request $request, Program $program, ?Live $live = null)
    {
        // Check Live Merge Section
        if (!$live) {

            $request->validate(['active_section' => 'required']);

            $live = Live::where('program_id', $program->getKey())
                ->where('section_id', $request->post('active_section'))
                ->first();
        }

        $merge = ($live->merge) ?  array($live->merge) : [];
        $section = ProgramSection::find($request->merge_with);
        $merge[$request->merge_with] = ["id" => $request->merge_with, "name" => $section->section_name];
        $live->merge = $merge;

        try {
            $live->save();
        } catch (\Throwable $th) {
            return $this->returnResponse(false, 'Error : ' . $th->getMessage(), null, [], 200, route('admin.program.admin_program_list'));
            //throw $th;
            //            session()->flash('error', "Error:" . $th->getMessage());
            //            return redirect()->route('admin.program.admin_program_list');
        }

        return $this->returnResponse(true, 'Session has been merged.', 'reload', [], 200, route('admin.program.admin_program_list'));
        //        session()->flash('success', "Session has been merged.");
        //        return redirect()->route('admin.program.admin_program_list');
    }

    public function rejoinSession(Live $live)
    {
        if (!$live->live) {
            return $this->returnResponse(false, 'Program Already Closed', null, [], 200, url()->current());
        }
        return $this->returnResponse(true, 'Session available.', 'redirectTab', ['location' => $live->admin_start_url], 200, $live->admin_start_url);
    }

    public function liveProgram()
    {
        $lives = Live::with(['zoomAccount', "program", 'programSection'])->where("live", true)->get();
        return view('admin.programs.live.list', ['lives' => $lives]);
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

    public function registerMemberToProgram(Request $request, ?Member $member, ?Program $program = null)
    {

        if (!$member) {
            $request->validate(['member' => 'required']);

            $member = Member::find($request->post('member'));
        }

        if (!$program) {
            $request->validate(['program' => 'required']);

            $program = Program::find($request->post('program'));
        }

        if (!$request->post('section')) {
            $programSection = $program->active_sections()->first();
        } else {
            $programSection = ProgramSection::find($request->post('section'));
        }

        if (!$request->post('batch')) {
            $programBatch = $program->active_batch()->first();
        } else {
            $programBatch = $program->batches()->where('batch_id', $request->post('batch'))->first();
        }

        // now check if this user is already in enrolled in the program.

        $programStudent = ProgramStudent::where('program_id', $program->getKey())
            ->where('student_id', $member->getKey())
            ->first();

        /**
         * @info If user is from Center just check if user exists or not, nothing more..
         */
        if (adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin()) {

            /**
             * If Center Force program to select from default one.
             */
            if ($request->post('section')) {
                $programSection = $program->active_sections()->first();
            }

            /**
             * If Center Froce batch to be from default.
             */
            if ($request->post('batch')) {
                $programBatch = $program->active_batch()->first();
            }

            if ($programStudent) {
                return $this->json(true, 'Student Enrolled in program', 'reload');
            }
        }

        if (in_array(adminUser()->role(), [Rule::ADMIN, Rule::SUPER_ADMIN]) && $programStudent) {

            if ($programStudent->batch_id = $programBatch->getKey()) {

                return $this->json(true, "Student Enrolled in program", "reload");
            }
        }

        if (!$programStudent) {

            $programStudent = new ProgramStudent();

            $programStudent->fill([
                'program_id' => $program->getKey(),
                'student_id'    => $member->getKey(),
                'batch_id'  => $programBatch->getKey(),
                'program_section_id'    => $programSection->getKey(),
                'active'    => true,
            ]);

            $programStudent->save();
        }

        return $this->json(true, 'Enroleld Success', 'reload');
    }
}
