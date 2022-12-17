<?php

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberEmergencyMeta;
use App\Models\MemberInfo;
use App\Models\Program;
use App\Models\ProgramBatch;
use App\Models\ProgramSection;
use App\Models\ProgramStudent;
use App\Models\ProgramStudentEnroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (request()->ajax() && request()->wantsJson()) {
            $members = Member::with(["emergency", "countries", "member_detail" => function ($query) {
                return $query->with(["program"]);
            }])->latest()->get();

            $datatable = DataTables::of($members)
                ->addIndexColumn()
                ->addColumn('full_name', function ($row) {
                    $full_name = htmlspecialchars($row->first_name);

                    if ($row->middle_name) {
                        $full_name .= " ";
                        $full_name .= $row->middle_name;
                    }
                    $full_name .= " ";
                    $full_name . $row->last_name;

                    return $full_name;
                })
                ->addColumn('login_source', function ($row) {
                    return strtolower(strip_tags($row->email));
                })
                ->addColumn('country', function ($row) {
                    // return $row->countries->country_name;
                    return ($row->countries) ? htmlspecialchars(strip_tags($row->countries->name)) : "NaN";
                })
                ->addColumn('phone', function ($row) {
                    $phone = "";
                    if ($row->phone_number) {
                        $phone .= "Mo: " . htmlspecialchars(strip_tags($row->phone_number));
                    } else {
                        $phone .= "NaN";
                    }
                    if ($row->emergency) {
                        $phone .= "<br />";
                        $phone .= "Ref Mo: " . htmlspecialchars(strip_tags($row->emergency->phone_number));
                        $phone .= "<br />";
                        $phone .= "Ref Name: " . htmlspecialchars(strip_tags($row->emergency->contact_person));
                    }
                    return $phone;
                })
                ->addColumn('program_involved', function ($row) {

                    if (!$row->member_detail->count()) {
                        return "NaN";
                    }
                    $program_involved = "";
                    foreach ($row->member_detail as $programs) {
                        $program_involved .= "<span class='bg-danger text-white px-2 mx-1'>" . $programs->program->program_name . "</span>";
                    }
                    return $program_involved;
                })
                ->addColumn('registered_date', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('action', function ($row) {
                    $action = "<a href='" . route('admin.members.show', $row->id) . "'>View Detail</a>";
                    return $action;
                })
                ->rawColumns(["country", "phone", "program_involved", "action"])
                ->make(true);
            return $datatable;
        }
        return view('admin.members.index');
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
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
        $member->load(['transactions' => function ($query) {
            return $query->with(['program']);
        }, 'donations', 'member_detail']);
        return view('admin.members.show', compact("member"));
    }


    public function programShow(Member $member, Program $program)
    {
        $member = $member->load(["meta", "emergency_contact", "member_detail", "countries", "cities"]);
        return view("admin.members.program-users", compact('member', 'program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
        $member->first_name = $request->first_name;
        $member->middle_name = $request->middle_name;
        $member->last_name = $request->last_name;
        $member->phone_number = $request->phone_number;
        $member->role = $request->role;
        $member->country = $request->country;
        $member->city = $request->city;
        $member->street_addres = ["street_address" => $request->street_address];

        if ($member->isDirty(["first_name", "middle_name", "last_name"])) {
            $member->full_name = $request->first_name . ($request->middle_name) ? $request->middle_name . " " . $request->last_name : " " . $request->last_name;
        }

        try {
            $member->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', $th->getMessage());
            return back();
        }

        session()->flash('success', "Personal Information updated.");
        return back();
    }

    public function programUpdate(Request $request, Member $member, MemberEmergencyMeta $emergencyMeta, Program $program = null)
    {
        $emergencyMeta->contact_person = $request->contact_person;
        $emergencyMeta->relation = $request->relation;
        $emergencyMeta->email_address = $request->email_address;
        $emergencyMeta->phone_number = $request->phone_number;

        try {
            $emergencyMeta->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Error: " . $th->getMessage());
            return back();
        }

        session()->flash('success', "Emergency Information updated");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }

    /**
     * add member to program.
     */
    public function add_member_to_program(Request $request, Program $program)
    {
        $batches = ProgramBatch::select(['batch_id'])->where('program_id', $program->id)->with(["batch" => function ($query) {
            return $query->select(["id", 'batch_name', "batch_year", 'batch_month']);
        }])->get();
        $sections = ProgramSection::where('program_id', $program->id)->get();
        return view('admin.programs.members.add', compact("program", "batches", "sections"));
    }

    public function store_member_to_program(Request $request, Program $program)
    {
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "phone" => "required|min:10",
            "profile" => "nullable|mimes:pdf,jpg,png",
            "password" => "required|min:7",
            "student_type" => "required|in:general,scholar,scholar_month,scholar_admission",
            "current_batch" => "required",
            "sections" => "required",
            "fee_voucher" => "nullable|mimes:pdf,jpg,png"
        ]);

        // check email or password match.
        $check_previous_record = Member::where("email", $request->email)->orWhere('phone_number', 'like', '%' . $request->phone . '%')->first();
        if ($check_previous_record) {
            session()->flash("error", "User Already Exists.");
            return back()->withInput();
        }

        $member = new Member;
        $member->first_name = $request->first_name;
        $member->middle_name = $request->middle_name;
        $member->last_name = $request->last_name;
        $member->source = "admin_entry";
        $member->email = $request->email;
        $member->password = Hash::make($request->password);
        $member->phone_number = $request->phone;
        $member->role_id = 3;
        $member->full_name = $request->first_name . (($request->middle_name) ? " " . $request->middle_name . " " : " ") . $request->last_name;

        // now add user to section and to batch as well
        $program_batch = new ProgramStudent;
        $program_batch->program_id = $program->id;
        $program_batch->program_section_id = $request->sections;
        $program_batch->batch_id = $request->current_batch;

        /**
         * Part for admission fee upload
         */
        try {
            DB::transaction(function () use ($program_batch, $member) {
                $member->save();
                // now save this student in student table as well.
                $program_batch->student_id = $member->id;
                $program_batch->save();
            });
            $program_batch->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            session()->flash("error", "Unable to save record.");
            return back()->withInput();
        }

        // 

        session()->flash("success", "New Record Created.");
        return back();
    }

    public function assign_member_to_program(Request $request, Program $program)
    {
        if ($request->ajax()) {
            // search member and display result.
            $members = Member::with(["member_detail" => function ($query) use ($program) {
                return $query->where('program_id', $program->id)
                    ->with(["program", "section", "batch"]);
            }])->where('email', $request->member)->orWhere('phone_number', 'like', '%' . $request->member . '%')->get();
            $batches = ProgramBatch::with(["batch"])->where('program_id', $program->id)->latest()->get();
            $sections = ProgramSection::where('program_id', $program->id)->latest()->get();
            return view('admin.programs.members.partials.search_result', compact('members', 'program', 'batches', 'sections'));
        }
        return view('admin.programs.members.assign_student_to_program', compact('program'));
    }

    public function store_member_to_class(Request $request, Program $program)
    {
        $request->validate([
            "section" => "required",
            "batch" => "required",
            "student" => "required"
        ]);
        $student_program = new ProgramStudent;
        // check if student is already assigned in this program.
        $student_program_exists = $student_program->where("program_id", $program->id)
            ->where('student_id', $request->student)->first();

        if ($student_program_exists) {
            // just change section is
            $student_program = $student_program_exists;
            $student_program_exists->program_section_id = $request->section;
            $student_program_exists->batch_id = $request->batch;
        } else {
            $student_program->program_id = $program->id;
            $student_program->program_section_id = $request->section;
            $student_program->student_id = $request->student;
            $student_program->batch_id = $request->batch;
            $student_program->active = true;
        }

        try {
            if ($student_program_exists) {
                $student_program_exists->save();
            } else {
                $student_program->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "success" => false,
                "message" => "Unable to create new record.",
                "error" => $th->getMessage()
            ]);
        }

        return response([
            "success" => true,
            "message" => "Student Assigned to program",
            "redirect" => false,

        ]);
    }

    public function get_member_fee_detail(Request $request, Program $program, Member $member)
    {
        $enrollment = ProgramStudentEnroll::where('program_id', $program->id)->where('member_id', $member->id)->first();
        return view('admin.programs.fee.partial.student_detail', compact("member", "program", "enrollment"));
    }

    /**
     * Update
     */
    public function upate(Request $request, Member $member)
    {
        $member->first_name = $request->first_name;
        $member->middle_name = $request->middle_name;
        $member->last_name = $request->last_name;

        if ($member->isDirty()) {
            $member->full_name = ($request->middle_name) ? $request->first_name . " " . $request->middle_name . " " . $request->last_name : $request->first_name . " " . $request->last_name;
        }

        $member->phone_number = $request->phone_number;
        $member->role_id = $request->role;
        $member->country = $request->country;
        $member->city = $request->city;
        $address = [
            "street_address" => $request->street_address
        ];
        $member->address = $address;

        try {
            $member->save();
        } catch (\Throwable $th) {
            session()->flash("error", "Error: " . $th->getMessage());
            return back();
        }

        session()->flash("success", "Information updated.");
        return back();
    }

    public function updatePersonal(Request $request, Member $member, MemberInfo $memberInfo = null)
    {
        if (!$memberInfo) {
            return $this->storeUpdatePersonal($request, $member);
        }
        $education = (array) $memberInfo->education;
        $personal = (array) $memberInfo->personal;

        $personal["date_of_birth"] = $request->date_of_birth;
        $personal["place_of_birth"] = $request->place_of_birth;
        $personal["gender"] = $request->gender;

        $education["education"] = $request->education;
        $education["education_major"] = $request->education_major;
        $education["profession"] = $request->profession;

        $memberInfo->personal = $personal;
        $memberInfo->education = $education;

        try {
            $memberInfo->save();
        } catch (\Throwable $th) {
            session()->flash("error", "Error: " . $th->getMessage());
            return back();
        }

        session()->flash("success", "Information Updated.");
        return back();
    }


    public function storeUpdatePersonal(Request $request, Member $member)
    {

        $memberInfo = new MemberInfo;
        $personal["date_of_birth"] = $request->date_of_birth;
        $personal["place_of_birth"] = $request->place_of_birth;
        $personal["gender"] = $request->gender;

        $education["education"] = $request->education;
        $education["education_major"] = $request->education_major;
        $education["profession"] = $request->profession;

        $memberInfo->personal = $personal;
        $memberInfo->education = $education;

        $memberInfo->member_id = $member->id;

        try {
            $memberInfo->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to save Member information. Error: " . $th->getMessage());
            return back();
        }
        session()->flash('success', "Member information Updated.");
        return back();
    }

    public function updatePassword(Request $request, Member $member)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $member->password = Hash::make($request->post('password'));

        try {
            $member->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to update User password');
            return back()->withInput();
        }

        session()->flash('success', "Password Updated for User.");
        return back();
    }

    public function reauthUser(Member $member)
    {
        if ($member->role_id != 7) {
            session()->flash('error', "Cannot debug non member account.");
            return back();
        }
        session()->put('adminAccount', auth()->id());

        if (!Auth::loginUsingId($member->id)) {
            session()->flash('error', 'Oops ! Unable to use debug for this user.');
            return back();
        }

        return redirect()->route('dashboard');
    }
}
