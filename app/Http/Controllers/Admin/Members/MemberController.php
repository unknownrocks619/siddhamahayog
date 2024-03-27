<?php

namespace App\Http\Controllers\Admin\Members;

use App\Classes\Helpers\Image;
use App\Classes\Helpers\Roles\Rule;
use App\Console\Commands\ImageToTable;
use App\Http\Controllers\Admin\Dharmasala\BookingController;
use App\Http\Controllers\Admin\Programs\AdminProgramController;
use App\Http\Controllers\Admin\Programs\ProgramStudentFeeController;
use App\Http\Controllers\Controller;
use App\Models\CenterMember;
use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\Dharmasala\DharmasalaBuildingRoom;
use App\Models\ImageRelation;
use App\Models\Images;
use App\Models\Member;
use App\Models\MemberEmergencyMeta;
use App\Models\MemberInfo;
use App\Models\Program;
use App\Models\ProgramBatch;
use App\Models\ProgramHoliday;
use App\Models\ProgramSection;
use App\Models\ProgramStudent;
use App\Models\ProgramStudentAttendance;
use App\Models\ProgramStudentEnroll;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use App\Models\Reference;
use App\Models\Role;
use App\Models\Scholarship;
use App\Models\SupportTicket;
use App\Models\UnpaidAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

            $searchTerm = (isset(request()->get('search')['value'])) ? request()->get('search')['value'] : '';

            $datatable = DataTables::of(Member::all_members($searchTerm))
                ->addIndexColumn()
                ->addColumn('full_name', function ($row) {
                   return htmlspecialchars(strip_tags($row->full_name));
                })
                ->addColumn('email', function ($row) {
                    $stringEmail = str($row->email);
                    if ($stringEmail->contains('random_email_') ) {
                        return 'N/A';
                    }

                    return $row->email;
                })
                ->addColumn('country', function ($row) {
                    // return $row->countries->country_name;
                    return $row->country_name ?? "NaN";
                })
                ->addColumn('phone', function ($row) {
                    $phone = "";
                    if ($row->phone_number) {
                        $phone .= "Mo: " . htmlspecialchars(strip_tags($row->phone_number));
                    } else {
                        $phone .= "NaN";
                    }
                    return $phone;
                })
                ->addColumn('program_involved', function ($row) {

                    if (!$row->program) {
                        return "NaN";
                    }
                    $allPrograms = explode(', ', $row->program);

                    $program_involved = "";
                    foreach ($allPrograms as $programs) {
                        $program_involved .= "<span class='bg-danger text-white px-2 mx-1'>" . $programs ."</span>";
                    }
                    return $program_involved;
                })
                ->addColumn('registered_date', function ($row) {
                    return date('Y-m-d',strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    // $action ='<a href="" data-bs-target="#quickUserView" data-bs-toggle="modal" data-bs-original-title="Quick Preview" class="text-primary"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                    $action = "<a href='" . route('admin.members.show', $row->member_id) . "' class='text-danger'><i class='ti ti-edit ti-sm me-2'></a>";
                    return $action;
                })
                ->rawColumns(["program_involved", "action"])
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
    public function create(Request $request, $source = null)
    {
        if ( $request->post() )  {

            // first create member
            if (! $request->post('memberID') ) {

                $request->validate([
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'date_of_birth' => 'required',
                    'gender' => 'required',
                    'phone_number' => 'required',
                    'city' => 'required',
                    'address' => 'required',
                    'country' => 'required',
                    'email' => 'required_if:enable_login,1',
                    'password' => 'required_if:enable_login,1|confirmed'
                ],
                    ['email.required_if' => 'Email Address is required.', 'password.required_if' => 'Password field is required.']);

                $request->validate(['gotra' => 'required']);

            }

            $fill = [
                'first_name'    => $request->post('first_name'),
                'middle_name'   => $request->post('middle_name'),
                'last_name'     => $request->post('last_name'),
                'phone_number'  =>  $request->post('phone_number'),
                'country'       => $request->post('country'),
                'city'          => $request->post('city'),
                'address'    => ['street_address' => $request->post('address')],
                'date_of_birth' => $request->post('date_of_birth'),
                'gender'        => $request->post('gender'),
                'gotra'         => $request->post('gotra'),
            ];

            $full_name = $fill['first_name'];

            if ( $fill['middle_name'] ) {
                $full_name .= " " . $fill['middle_name'];
            }

            $full_name .= " " . $fill['last_name'];

            $fill['full_name']  = $full_name;

            $member = null;

            if ( $request->post('exisiting_member') && $request->post('memberID') ) {
                $member = Member::find($request->post('memberID'));

            } elseif ($request->post('email')) {
                $member = Member::where('email',$request->post('email'))->first();
            }

            if ($member ) {
                $member->date_of_birth = $fill['date_of_birth'] ?? $member->date_of_birth;
                $member->country = $fill['country'] ?? $member->country;
                $member->city = $fill['city'] ?? $member->city;
                $member->address = isset($fill['address']['street_address']) && ! is_null($fill['address']['street_address']) ? $fill['address']['street_address'] : $member->address;
                $member->first_name = $fill['first_name'] ?? $member->first_name;
                $member->last_name = $fill['last_name'] ?? $member->last_name;
                $member->middle_name = $fill['middle_name'] ?? $member->middle_name;

                if ( ! $member->gotra ) {
                    $member->gotra = $fill['gotra'];
                }

                if ( ! $member->phone_number && $fill['phone_number']) {
                    $member->phone_number = $fill['phone_number'];
                }

            } else {
                $member = new Member();
                $member->fill($fill);
                $member->source = ($request->has('dharmasala') && $request->get('dharmasala') == true)  ? 'dharmasala' : 'admin_entry';
                $member->password = $request->post('password') ? Hash::make($request->post('password')) : Hash::make(Str::random(8).time());
                $member->sharing_code = Str::random(8);
                $member->email = $request->post('email') ?? 'random_email_'.Str::random(18).'_'.time().'@siddhamahayog.org';
            }

            if ( ! $member->phone_number ) {
                $request->validate(['phone_number' => 'required']);
            }

            if ( ! $member->gotra ) {
                $request->validate(['gotra' => 'required']);
            }

            try {
                $dharmasalaResponse = null;

                DB::transaction(function() use ($member,$request, $source, &$dharmasalaResponse) {
                    /**
                     * Save only if required.
                     */
                    if ($member->isDirty() ) {

                        $member->full_name = $member->full_name();
                        $member->save();
                    }

                    /**
                     * Upload ID Card Image
                     */

                    if ($request->file('id_card') ) {

                        $memberIDCard = Image::uploadImage($request->file('id_card'),$member);

                        if (isset ($memberIDCard[0]['relation'])) {
                            $memberCardType = $memberIDCard[0]['relation'];
                            $memberCardType->type = 'id_card';
                            $memberCardType->save();
                        }

                    } elseif (! $request->file('id_card') && $request->post('id_card_image') ) {

                        $isUrl = str($request->post('id_card_image'))->contains('http');

                        if ( $isUrl) {

                            $idMediaImage = $request->post('id_card_image');
                        } else {
                            $idMediaImage = (new BookingController())->uploadMemberMedia($request,$request->post('id_card_image'),'path');
                        }
                        $uploadImageFromUrl = Image::urlToImage($idMediaImage,'dharmasala-processing');

                        if (! $uploadImageFromUrl instanceof  Images)  {
                            throw new \Error('Unable to verify ID Card. Please try again or try uploading image.');
                        }

                        $imageRelation = (new ImageRelation())->storeRelation($member,$uploadImageFromUrl);
                        $imageRelation->type = 'id_card';
                        $imageRelation->saveQuietly();

                    }

                    /**
                     * Upload Profile Picture.
                     */

                     if ($request->file('profile_image') ) {

                        $memberIDCard = Image::uploadImage($request->file('profile_image'),$member);

                        if (isset ($memberIDCard[0]['relation'])) {
                            $memberCardType = $memberIDCard[0]['relation'];
                            $memberCardType->type = 'profile_picture';
                            $memberCardType->save();
                        }

                    } elseif (! $request->file('profile_image') && $request->post('live_webcam_image') ) {

                        $isUrl = str($request->post('live_webcam_image'))->contains('http');

                        if ( $isUrl) {
                            $idMediaImage = $request->post('live_webcam_image');
                        } else {
                            $idMediaImage = (new BookingController())->uploadMemberMedia($request,$request->post('live_webcam_image'),'path');
                        }

                        $uploadImageFromUrl = Image::urlToImage($idMediaImage,'dharmasala-processing');

                        if (! $uploadImageFromUrl instanceof  Images)  {
                            throw new \Error('Unable to verify Profile Image. Please try again or try uploading image.');
                        }

                        $imageRelation = (new ImageRelation())->storeRelation($member,$uploadImageFromUrl);
                        $imageRelation->type = 'profile_picture';
                        $imageRelation->saveQuietly();

                    }

                    /**
                     * Insert record into dharmasal booking.
                     */
                    if ( $request->has('dharmasala') && $request->get('dharmasala') == true) {
                        $dharmasalaResponse = (new BookingController())->createNewUserBooking($request,$member);
                    }

                    /**
                     * Insert member into this center.
                     */
                    if ( ( adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin() ) && ! CenterMember::where('member_id',$member->getKey())->where('center_id',adminUser()->center_id)->exists()){

                        $centerMember = new CenterMember();
                        $centerMember->fill([
                            'member_id' => $member->getKey(),
                            'center_id' => adminUser()->center_id
                        ]);

                        $centerMember->save();
                    }


                    if ($request->post('program_enroll') && ! $request->post('family_confirmation')) {

                        $programControll = (new AdminProgramController())->registerMemberToProgram($request,$member);

                        if (isset($programControll->original['state']) && ! $programControll->original['state']) {
                            throw new Error($programControll->original['msg']);
                        }

                    }

                    #Course Fee Entry
                    if ($request->has('amount') || $request->has('voucher_type')) {

                        $courseFeeEntry = (new ProgramStudentFeeController())->add_fee_to_student_by_program($request,null,$member);

                        if (isset($courseFeeEntry->original['state']) && ! $courseFeeEntry->original['state']) {
                            throw new Error($courseFeeEntry->original['msg']);
                        }

                    }

                    if ($request->has('family_confirmation') ) {
                        (new MemberEmergencyController())->bulkInsert($request,$member);
                    }

                });

            } catch (\Error $error ) {

                return $this->json(false,'Failed to create. Error: '. $error->getMessage(),'',['alert' =>'swal']);
            }

            if ($dharmasalaResponse){

                return $dharmasalaResponse;
            }

            /**
             * If member registration is done by
             * centers than confirm for enrollment
             * in one of the program.
             *
             * @info This is to avoid unnecessary enrollment of members only in the system.
             * @todo Upgrade with better option.
             */


            $view = 'admin.programs.members.post-registration';
            $params =['member' => $member];

            if ($request->post('program_enroll') && $request->post('family_confirmation')) {
                $view = 'admin.programs.members.post-enrollement-option';
            } else if($request->post('program_enroll') && ! $request->post('family_confirmation')) {
                $params['program'] = Program::find($request->post('program'));
                $view ='admin.programs.members.family-confirmation';

            }

            return $this->json(true,'Member Registration Success.','validatePartials',[
                'view'  => view($view,$params)->render()
            ]);
        }

        $member = null;
        if ($request->get('member') ) {
            $member = Member::find($request->get('member'));
        }

        return view("admin.members.create",['member' => $member]);
    }

    public function memberVerification(Request $request) {

        $view = 'admin.members.partials.new-registration';
        $memberSearch = collect([]);
        $params = [];

        if (! $request->get('new-registration') && ! $request->get('member')) {
            $memberSearch = Member::where('email',$request->post('userKeyword'))
                ->orWhere('phone_number','LIKE','%'.$request->post('userKeyword').'%')
                ->orWhere('full_name','LIKE','%'.$request->post('userKeyword').'%')
                ->limit(20)
                ->with(['profileImage'])
                ->get();

            if (! $memberSearch->count() ) {
                $searchTerm = str($request->post('userKeyword'));
                if ($searchTerm->contains(':') ) {
                    $registrationCode = explode(':',$request->post('userKeyword'));
                    $memberSearch = Member::where('id',(int) $registrationCode[1])->with(['profileImage'])->get();
                }
            }

            if ($memberSearch->count() ) {
                $view = 'admin.members.partials.member-selection';
                $params['members'] = $memberSearch;
            } else {}
        }

        if ( $request->get('member') ) {
            $params['member'] = Member::find($request->get('member'));
        }

        $email = filter_var($request->post('userKeyword'),FILTER_VALIDATE_EMAIL);
        $params['email'] = $email;
        $params['dharmasala'] = $request->post('dharmasala');

        return $this->json(true,'','validatePartials',['view' => view($view,$params)->render()]);
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
    public function show(Member $member,$tab = 'user-detail')
    {
        ini_set('allow_url_fopen', 1);
        ini_set('memory_limit',-1);

        $superAdmin = ['billing'];
        if ( in_array($tab,$superAdmin) && ! adminUser()->role()->isSuperAdmin() ) {
            return redirect()->route('admin.members.show',['member' => $member,'tab' => 'user-detail']);
        }
        //
        session()->forget('adminAccount');

        $member->load(['transactions' => function ($query) {
            return $query->with(['program']);
        }, 'donations', 'member_detail']);

        $setNull = false;

        if(config('app.env') != 'local')  {

            if ($member->profile && isset ($member->profile->full_path)) {

                $url = str_replace('uploads/m','uploads/cus', $member->profile->full_path);
                $originalFilename = pathinfo($url,PATHINFO_FILENAME);
                (new ImageToTable())->downloadAndSaveImage($url,$member,$originalFilename,'profile_picture');
                $setNull = true;
            }

            if ($member->profile && isset($member->profile->id_card) ) {
                $url = str_replace('uploads/m','uploads/cus', $member->profile->id_card);
                $originalFilename = pathinfo($url,PATHINFO_FILENAME);
                (new ImageToTable())->downloadAndSaveImage($url,$member,$originalFilename,'id_card');
                $setNull = true;
            }

            if ( $member->profile &&  isset($member->profile->path) ) {
                $originalFilename = $member->profile->original_filename;
                $url = asset($member->profile->path);
                (new ImageToTable())->downloadAndSaveImage($url,$member,$originalFilename,'profile_picture');
                $setNull = true;
            }

        }

        if ($setNull === true) {
            $member->profile = null;
            $member->save();
        }

        return view('admin.members.show', compact("member","tab"));
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

        $member->first_name = $request->post('first_name');
        $member->middle_name = $request->post('middle_name');
        $member->last_name = $request->post('last_name');

        if(in_array(adminUser()->role(),[Rule::ADMIN,Rule::SUPER_ADMIN] ) ) {
            $member->phone_number = $request->post('phone_number');
            $member->email = $request->post('email');
            $member->role_id = $request->post('role');
        }

        if ($member->isDirty('email') && Member::where('email', $request->post('email'))
                ->where('id', '!=', $member->getKey())
                ->whereNotNull('email')
                ->exists()) {
            return $this->json(false,'Email Already Exists. Unable to save Record.');
        }

        $member->country = $request->post('country');
        $member->city = $request->post('city');
        $member->address = ["street_address" => $request->post('street_address')];
        $member->full_name = $member->full_name();

        try {
            $member->save();
            $this->updatePersonal($request,$member,$member->meta);

        } catch (\Throwable $th) {
            //throw $th;
            return $this->json(false,'Error: '. $th->getMessage());
            session()->flash('error', $th->getMessage());
            return back();
        }

        // update
        return $this->json(true,'Information updated.');
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
    public function add_member_to_program(Request $request, ?Program $program=null)
    {

        $data = [
            'program' => $program
        ];

        if ($program) {

            $batches = ProgramBatch::select(['batch_id'])->where('program_id', $program->id)->with(["batch" => function ($query) {
                return $query->select(["id", 'batch_name', "batch_year", 'batch_month']);
            }])->get();

            $sections = ProgramSection::where('program_id', $program->id)->get();
            $data['batches'] = $batches;
            $data['sections'] = $sections;
        }
        return view('admin.programs.members.add', $data);
    }

    public function store_member_to_program(Request $request, Program $program)
    {
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "phone" => "nullable|min:10",
            "profile" => "nullable|mimes:pdf,jpg,png",
            "password" => "nullable|min:7",
//            "student_type" => "required|in:general,scholar,scholar_month,scholar_admission",
            "current_batch" => "required",
            "sections" => "required",
            "fee_voucher" => "nullable|mimes:pdf,jpg,png"
        ]);

        // check email or password match.
        $check_previous_record = Member::where("email", $request->post('email'))
                                        ->first();

        if ($check_previous_record) {
            return $this->returnResponse(false,'User Already exists.',null,[],200,route('admin.members.admin_add_member_to_program',['program' => $program->getKey()]));
        }

        $member = new Member;
        $member->fill([
            'first_name' => $request->post('first_name'),
            'middle_name' => $request->post('middle_name'),
            'last_name' => $request->post('last_name'),
            'source' => "admin_entry",
            'email' => $request->post('email'),
            'password' => Hash::make($request->password ?? Str::random(8)),
            'phone_number' => $request->post('phone'),
            'role_id' => $request->post('role') ?? 3,
            'full_name' => $request->post('first_name') . (($request->post('middle_name')) ? " " . $request->post('middle_name') . " " : " ") . $request->post('last_name'),
            'country' => $request->post('country'),
            'city' => $request->post('city'),
            'address' => ['street_address' => $request->post('street_address')],
            'date_of_birth' => $request->post('date_of_birth'),
            'gender'            => $request->post('gender'),
            'gotra'             => $request->post('gotra'),
        ]);

        if (adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin() ) {
            $member->role_id = Role::MEMBER;
        }

        // get program batch
        $programBatch = ProgramBatch::where('batch_id',$request->post('current_batch'))
            ->where('program_id',$program->getKey())
            ->first();


        // now add user to section and to batch as well
        $program_batch = new ProgramStudent;

        $program_batch->fill([
            'program_id'            => $program->getKey(),
            'program_section_id'    => $request->post('sections'),
            'batch_id'              => $programBatch->getKey(),
            'active'                => true
        ]);

        /**
         * Part for admission fee upload
         */
        try {
            DB::transaction(function () use ($program_batch, $member, $request) {
                $member->save();
                // now save this student in student table as well.
                $program_batch->student_id = $member->getKey();
                $program_batch->save();



                if ( $request->post('place_of_birth') ) {
                    $memberInfo = new MemberInfo();
                    $memberInfo->fill([
                        'personal' => ['date_of_birth' => $request->post('date_of_birth'),'place_of_birth' => $request->post('place_of_birth')],
                        'education' => [],
                        'member_id' => $member->getKey()
                    ]);

                    $memberInfo->save();

                }

//                $programEnroll = ProgramStudentEnroll::where('student_id',$member->getKey())
//                                                        ->where('program_section_id', $program_batch->section_id)
//                                                        ->where('batch_id',$program_batch->batch_id)
//                                                        ->first();
//                if (! $programEnroll ) {
//                    $programEnroll->fill([
//                        ''
//                    ]);
//                }
            });

        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Unable to save Record',null,['error : ' . $th->getMessage()],200,route('admin.members.admin_add_member_to_program',['program' => $program->getKey()]));
        }
        //
        return $this->returnResponse(true,'New Record Created.','redirect',['location' => route('admin.program.admin_program_detail',['program' => $program->getKey()])],200,route('admin.program.admin_program_detail',['program' => $program->getKey()]));
    }

    public function assign_member_to_program(Request $request, Program $program)
    {
        if ($request->ajax()) {

            // search member and display result.
            $members = Member::with(["member_detail" => function ($query) use ($program) {
                return $query->where('program_id', $program->id)
                    ->with(["program", "section", "batch"]);
            }])
            ->where('email', $request->member)
            ->orWhere('phone_number', 'like', '%' . $request->member . '%')
                ->orWhere('first_name','LIKE','%'.$request->member.'%')
                ->orWhere('last_name','LIKE','%'.$request->member.'%')
                ->orWhere('full_name','LIKE','%'.$request->member.'%')
            ->limit(30)->get();

            $batches = ProgramBatch::with(["batch"])->where('program_id', $program->getKey())->latest()->get();
            $sectionQuery = ProgramSection::where('program_id', $program->getKey());

            if ($request->get('section') ) {
                $sectionQuery->where('id',$request->get('section'));
            }
            $sections = $sectionQuery->latest()->get();

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
        $student_program_exists = $student_program->where("program_id", $program->getKey())
            ->where('student_id', $request->post('student'))->first();

        if ($student_program_exists) {
            // just change section is
            $student_program = $student_program_exists;
            $student_program_exists->program_section_id = $request->post('section');
            $student_program_exists->batch_id = $request->post('batch');
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
        $member->full_name = $member->full_name();

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
            return $this->returnResponse(false,'Error: '. $th->getMessage());
            //throw $th;
//            session()->flash('error', 'Unable to update User password');
//            return back()->withInput();
        }

        return $this->json(true,'Password updated.');
//        session()->flash('success', "Password Updated for User.");
//        return back();
    }

    public function reauthUser(Member $member)
    {
        if ( ! adminUser()->role()->isSuperAdmin() ) {
            return $this->json(false,'You do not have permission to perform this action.');
        }

        session()->put('adminAccount', true);

        if (!Auth::loginUsingId($member->getKey())) {
            return $this->returnResponse(false,'Oops ! Unable to use debug for this user.');
        }

        return $this->returnResponse(true,'Debug is now enabled.','redirect',['location' => route('dashboard')]);
    }

    public function calcel_subscription(Program $program, Member $member)
    {

        $enroll = ProgramStudent::where('program_id', $program->getKey())->where('student_id', $member->getKey())
            ->first();

        // check of transactions for this program
        $studentFeeDetail = ProgramStudentFeeDetail::where('student_id', $member->getKey())
            ->where('program_id', $program->getKey())
            ->get();

        try {

            DB::transaction(function () use ($studentFeeDetail, $enroll, $member, $program) {

                // $totalAmount = $studentFeeDetail->sum('amount');
                // $fee = $studentFeeDetail->student_fee();
                // $fee->delete();
                // $studentFeeDetail->delete();
                /**
                 * @todo Infuture just incase we have different amount from main
                 * account
                 */
                // if ($totalAmount == $fee->total_amount) {
                //     $studentFeeDetail->delete();
                //     $fee->delete();
                // } else {
                //     $fee->total_amount = $fee->total_amount - $totalAmount;
                //     $fee->save();
                //     $studentFeeDetail->delete();
                // }

                $enroll->active = false;
                $enroll->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unble to update enrollment status');
            return back();
        }

        session()->flash('success', 'Student Enrolment has been marked as inactive.');
        return back();
    }

    /**
     * Delete user
     * @param Member $member
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function deleteUser(Member $member)
    {

        if ( ! adminUser()->role()->isSuperAdmin() ) {
            return $this->json(false,'You do not have permission to perform this action.');
        }

        if (Role::ADMIN != user()->role_id) {
            session()->flash('error', 'You are not allowed to perform this action.');
            return back();
        }

        try {
            //code...
            DB::transaction(function () use ($member) {
                // search for
                \App\Models\Donation::where('member_id', $member->getKey())->delete();
                MemberEmergencyMeta::where('member_id', $member->getKey())->delete();
                MemberInfo::where('member_id', $member->getKey())->delete();
                ProgramHoliday::where('student_id', $member->getKey())->delete();
                ProgramStudentAttendance::where('student', $member->getKey())->delete();
                ProgramStudent::where('student_id', $member->getKey())->delete();
                ProgramStudentEnroll::where('member_id', $member->getKey())->delete();
                ProgramStudentFeeDetail::where('student_id', $member->getKey())->delete();
                ProgramStudentFee::where('student_id', $member->getKey())->delete();
                Reference::where('referenced_to', $member->getKey())->orWhere('referenced_by', $member->getKey())->delete();
                Scholarship::where('student_id', $member->getKey())->delete();
                SupportTicket::where('member_id', $member->getKey())->delete();
                UnpaidAccess::where('member_id', $member->getKey())->delete();
                $member->delete();
            });
        } catch (\Throwable $th) {
            return $this->json(false,'Unable to to remove user. '. $th->getMessage());
        }

        return $this->json(true,'User information deleted.','reload');
    }
}
