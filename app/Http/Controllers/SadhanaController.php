<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userDetail;
use App\Models\userLogin;
use Nepali;
use App\Models\UserSadhanaCenter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Models\SadhakMentalQueries;
use App\Models\UserSadhakRegistration;
use App\Models\UserSibirRecord;
use App\Models\UserSibirTrack;
use Illuminate\Support\Facades\App;
use App\Models\userReference;
use App\Models\SibirRecord;
use App\Models\EventVideoClass;
use App\Models\VideoClassLog;
use App\Models\UserFamilyGroup;
use App\Models\EventAbsentRecord;
use DataTables;
class SadhanaController extends Controller
{


    public function index() {
        $programs = SibirRecord::get();
        return view("admin.sadhana.index",compact('programs'));
    }

    public function sibir_add_form() {
        return view('admin.sadhana.add');
    }

    public function sibir_edit_form(SibirRecord $sibir) {

        return view("admin.sadhana.edit",compact('sibir'));
    }

    public function report(SibirRecord $sibir) {
        
        if ( isAdmin() ) {
            return view('admin.sadhana.report',compact('sibir'));
        }

    }

    public function close_sibir_record(SibirRecord $sibir) {
        $sibir->delete();
        request()->session()->flash('success','Application Closed');
        return back();
    }

    public function update_sibir_form(Request $request, SibirRecord $sibir) {
        $sibir->sibir_title = $request->application_title;
        $sibir->total_capacity = $request->total_capacity;
        $sibir->start_date = $request->start_date;
        $sibir->end_date = $request->end_date;
        $sibir->active = ($request->active) ? true : false;
        if($sibir->isDirty()){
            $sibir->save();
        }
        $request->session()->flash('success',"Sibir Information Updated.");
        return back();
    }

    public function save_sibir_form(\App\Http\Requests\SibirRecordRequest $request){
        $post_record = [
            "sibir_title" => $request->application_title,
            'total_capacity' => $request->total_capacity,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' => ($request->active && $request->active == "on") ? true : false,
            'user_detail_id' => auth()->user()->user_detail_id,
            'user_login_id' => auth()->user()->id,
            'slug' => \Str::slug($request->application_title)
        ];
        try {
            $sibir_record = SibirRecord::create($post_record);
            $request->session()->flash('success','New Sibir Information Record');
            return back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            // return back()->withErrors([$th->getMessage()]);
        }

    }

    public function show(Request $request, UserSadhakRegistration $user, $type= null){
        $data = [
            'user_registration' => $user,
            "user_detail" => $user->userDetail,
            'action' => [
                'pending' => ['verified'=>"Verify",'cancelled' => "Cancel",'confirmed'=>"Confirm",'completed' => "Complete"],
                'verified' => ['confirmed'=>"Confirm",'cancelled'=>"Cancel",'completed'=>'Complete'],
                'confirmed' => ['completed'=>"Complete"],
                'completed' => ["No Action is Required"]
            ]
        ];
        $page = "sadhak-detail";
        if ($type == "health") {
            $page = "health-detail";
            $data['user_mental_queries'] = SadhakMentalQueries::where('user_detail_id',$data["user_detail"]->id)->latest()->first();
        }

        if ($type == "review") {

        }

        if ($type == "history") {
            
        }

        if (isAdmin() ) {
            return view('admin.users.sadhak-entry.'.$page,$data);
        } 

        if (isCenter()) {
            return view('centers.users.sadhak-entry.'.$page,$data);

        }
    }

    public function change_status(Request $request,UserSadhakRegistration $user,$type){

        // different condition for different status.

        $user_preferences = $user->user_preferences;
        $user_detail = $user->userDetail;


        // create set of action required.
        $db_action = null;

        if($user_preferences->pending) {
            $db_action = "pending";
        } 
        if ($user_preferences->verified) {
            $db_action = 'verified';
        } 

        if($user_preferences->confirmed) {
            $db_action = 'confirmed';
        }

        if ($user_preferences->completed) {
            $db_action = "completed";
        }

        /**
         *  
         * Future Reference ***
         * 
         * controlled action, only given values are allowed to perform 
         * */
        $action = [
            'pending' => ['verified','cancelled','completed','confirmed'],
            'verified' => ['confirmed','cancelled','completed'],
            'confirmed' => ['completed'],
            'completed' => []
        ];
        //
        if ( ! array_key_exists($db_action,$action) || ! in_array($type,$action[$db_action])) {
            abort(403);
        }

        /**
         * Future Reference
         */
        // also lets setup review verification for complete action.
        // if ( ! $user->user_reviews && $request->ajax()) 
        // {
        //     return response(["error"=>true,'message'=>"Review must be submitted."]);
        // } elseif ( ! $user->user_reviews) {
        //     return back()->withErrors(["Review Must be submitted."]);
        // }

        // now we have review as well, lets update content
        $user_preferences->$db_action = false;
        $user_preferences->$type = true;

       


        try {
            \DB::transaction(function () use ($user_detail,$user,$user_preferences,$action,$type) {
                // now let's commit and make changes.
                // dd();
                if ($type == "completed" ) {
                    $user->is_active = false;
                    $user->save();
                }
                $user_preferences->save();
                
                if ( $type == "completed") {
                    $user_sibir_record = new UserSibirRecord;
                    $user_sibir_record->user_detail_id = $user->user_detail_id;
                    $user_sibir_record->branch_id = $user->branch_id;
                    $user_sibir_record->sibir_id = $user->sibir_record_id;
                    // also fetch sibir record id
                    // $sibir_record = $user->sibir->id;
                    // $user_sibir_record->sibir_start_date_eng = $sibir_record->start_date;
                    $user_sibir_record->sibir_end_date_eng = date("Y-m-d");
                    $user_sibir_record->sibir_duration = '1';
                    $user_sibir_record->save();
                }

                if ( $type == "verified" ) {

                    // now lets also save this reference.
                    $reference_save = [
                        'center_id' => $user->branch_id,
                        'user_detail_id' => $user->user_detail_id,
                        'created_by_user' => auth()->user()->id
                    ];
                    $userreference = userReference::create($reference_save);
                    // $user_detail->userreference->center_id = $user->branch_id;
                    // $user_detail->userreference->user_detail_id = $user->user_detail_id;
                    // $user_detail->userreference->created_by_user = auth()->user()->id;
                    // $user_detail->userreference->save();
                }
            });

            $request->session()->flash("success","User Status Changed.");
            if ( $request->ajax() ) {
                return response ([
                    "error" => "false",
                    'message' => 'Status Changed Successfully.',
                    'action' => "success"
                ],200);
            }
            return back();
        } catch (\Throwable $th) {
            //throw $th;
            dd ( $th->getMessage() );
        }
    }

    public function first_user_draft(\App\Http\Requests\SadhakRegistrationRequest $request){
        App::setLocale(request()->session()->get('locale'));    

        // validate and verify user email.
        $check_email = userLogin::where(
                    [
                        'email'=>request()->email_address,
                        // 'phone_number' => request()->contact_number
                    ])->first();
        if ( $request->user_registration == "yes" && $check_email )
        {
            // if email is already register notify user and send verification link.
            return back()->withErrors(['This email already has already been registerd. Please select different option if you have already visited.'])->withInput();
        }
        
        if ($request->user_registration == "no" && ! $check_email) {
            return back()->withErrors(["Email Address doesn't exists. If you are new here, try next option."])->withInput();
        }

        if ($request->user_registration == "no" && $check_email) {            
            // return redirect($this->generate_signed_url([$check_email->user_detail_id],'user-registraion-exist',10));
            return redirect($this->generate_signed_url ([$check_email->user_detail_id],'sadhana-step-two',30));

        }
        $nepali_class= new Nepali;
        if (App::currentLocale() == "np") {

            // explode record.
            $explode_nepali_date = explode("-",$request->date_of_birth);
            $eng_date = $nepali_class->get_eng_date($explode_nepali_date[0],$explode_nepali_date[1],$explode_nepali_date[2]);
            $post_record["date_of_birth_nepali"] = $request->date_of_birth;

            $eng_final_date = date("Y-m-d" ,
                                    strtotime($eng_date["y"]."-".$eng_date['m']."-".$eng_date["d"])
                                );
            $post_record["date_of_birth_eng"] = $eng_final_date;

        } else {
            $nep_date = $nepali_class->get_nepali_date(
                    date("Y",strtotime($request->date_of_birth)),
                    date("m",strtotime($request->date_of_birth)),
                    date("d",strtotime($request->date_of_birth))
            );
            $date_of_birth_nepali = $nep_date["y"].'-'.$nep_date['m'].'-'.$nep_date['d'];
            $post_record["date_of_birth_nepali"] = $date_of_birth_nepali;
            $post_record["date_of_birth_eng"] = $request->date_of_birth;
        }

        $post_record = $request->all();
        $post_record["phone_number"] = $request->contact_number;
        $post_record["education_level"] = $request->education_background;
        $post_record["user_type"] = "Non-Dikshit";
        // $post_record["date_of_birth_eng"] = $request->date_of_birth;
        // $post_record["date_of_birth_nepali"] = $date_of_birth_nepali;
        $post_record["emergency_contact"] = $request->emeregency_contact_number;
        $post_record["relation_with_emergency_contact"] = $request->emeregency_relation;
        $post_record["emeregency_contact_name"] = $request->emeregency_full_name;

        try {   
            $route_path = \DB::transaction( function ( ) use($post_record,$request,$check_email) {
                $inserted_record = userDetail::create($post_record);

                $user_sadhan_center = new UserSadhanaCenter;
                $user_sadhan_center->user_detail_id = $inserted_record->id;
                $user_sadhan_center->center_id = $request->center;
                $user_sadhan_center->reference_type = "sign up";

                $user_sadhan_center->save();

                $user_login_model = new userLogin;
                $user_login_model->user_detail_id = $inserted_record->id;
                $user_login_model->user_type = "public";
                $user_login_model->email = $request->email_address;
                $user_login_model->password = Hash::make(Str::random(15));

                $user_login_model->save();

                // now lets create signed url to complete the proccess.
                // return 
                // dd("hello");
                return $this->generate_signed_url ([$inserted_record->id],'sadhana-step-two',30);
                
            });

            return redirect($route_path);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->withErrors([$th->getMessage()])->withInput();
        }
    }

    private function generate_signed_url($query=[],$route_name = "sadhana-step-two",$minute= 30) {
        return URL::temporarySignedRoute(
                $route_name,now()->addMinutes($minute),$query);
    }

    public function second_user_draft(Request $request , userDetail $user){
        App::setLocale(request()->session()->get('locale'));    

        if ( ! $request->hasValidSignature() ){
            abort(401);
        }
        $param = [$user->id];
        if($request->exist_user){
            $param["exist_user"] = $request->exist_user;
        }
        $signature = $this->generate_signed_url($param,"sadhana-application-submission",30);
        return view("public.user.sadhana.sadhak-other-info",compact('user',"signature"));
    }

    public function submit_user_application(\App\Http\Requests\SadhanaMentalQueriesRequest $request,userDetail $user) 
    {
        App::setLocale(request()->session()->get('locale'));    

        if ( ! $request->hasValidSignature() ){
            abort(401);
        }
        $mental_quries  = [
            'user_detail_id' => $user->id,
            'is_visitor_alone' => ($request->is_alone == "no") ? false  : true,
        ];
        if ($request->is_alone == "no") {
            $mental_quries["visitors_relative_name"] = $request->relative_name;
            $mental_quries["visitors_relative_relation"] = $request->relative_relation;
        }

        $mental_quries["is_first_visit"] = ($request->first_visit == "yes")  ? true : false;
        $mental_quries["have_physical_difficulties"] = ($request->physical_difficulties == "yes") ? true :false;
        
        if ($mental_quries["have_physical_difficulties"]) {
            $mental_quries["describe_physical_difficulties"] = $request->health_problem_description;
        }

        $mental_quries["have_mental_problem"] = ($request->mental_health == "no") ? false : true;

        if ($mental_quries["have_mental_problem"]) {
            $mental_quries["describe_mental_difficulties"] = $request->describe_mental_difficulties;
        }

        $mental_quries["have_practiced_before"] = ($request->practiced_before == "no")  ? false :true;
        $mental_quries["ads_source"] = $request->our_ads_source;
        $mental_quries["is_agreed_terms"] = $request->terms_and_condition;
        $mental_quries["visitors_relative_contact"] = $request->relative_relation_contact;

        $sadhana_model = new SadhakMentalQueries;

        // lets generate 

        try {
            //code...
            \DB::transaction(function() use ($user,$mental_quries,$sadhana_model,$request) {
                $sadhana_model->create($mental_quries);
                //
                $user_sadhak_registration = new UserSadhakRegistration;
                $user_sadhak_registration->user_detail_id = $mental_quries["user_detail_id"];
                $user_sadhak_registration->branch_id = $user->sibir_preference->center_id;
                $user_sadhak_registration->user_sadhak_registration_preference_id = $user->sibir_preference->id;
                $user_sadhak_registration->is_active = true;
                $user_sadhak_registration->is_new = false;

                if ( $request->exist_user) {
                    $user_sadhak_registration->is_new = true;
                } 

                $user_sadhak_registration->save();
                
            });

            if ($request->first_visit == "yes") {
                // lets redirect to other detail form.
                return redirect($this->generate_signed_url[$user->id],'user-registraion-exist',10);
            }

            return redirect($this->generate_signed_url([$user->id],'application-complete',5));

        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->withErrors(["Something went wrong."])->withInput();
        }

        // if( $sadhana_model->create($mental_quries) )
        // {
            
        //     return redirect($this->generate_signed_url([$user->id],'application-complete',5,));
        // }

        // return back()->withErrors(["Something went wrong"])->withInput();

    }

    public function complete_application(userDetail $user){
        App::setLocale(request()->session()->get('locale'));    

        if (! request()->hasValidSignature()){
            abort(401);
        }
        return view('public.user.sadhana.sadhak-registration-complete',compact('user'));
    }


    public function existing_user_verify(Request $request)
    {
        App::setLocale(request()->session()->get('locale'));    

        $user_login_record = userLogin::where('email',$request->email)->findOrFail();
        return redirect($this->generate_signed_url([$user_login_record->user_detail_id],"user-registraion-exist",10));
    }

    public function exisiting_user_second_step(userDetail $user){
        App::setLocale(request()->session()->get('locale'));    

        if ( ! request()->hasValidSignature() ) {
            return redirect()->route('sadhana-registration-one');
        }
        $records = $user->sibir_records;
        // $records = ($sibir_records->count() > 0 ) ? $sibir_records : null;
        return view("public.user.sadhana.registration-old-info",compact('user','records'));
    }

    public function enquries(\App\Http\Requests\OldSadhakHistoryRequest $request, userDetail $user)
    {
        App::setLocale(request()->session()->get('locale'));    

        $UserSibirRecord = new UserSibirRecord;
        $UserSibirRecord->user_detail_id = $user->id;
        $UserSibirRecord->verified = false;
        try {
            \DB::transaction(function() use ($UserSibirRecord,$request,$user) {

                $sibir_track_history = new UserSibirTrack;
                $sibir_track_history->continued = ($request->daily_practice == "yes") ? true :false;
                $sibir_track_history->is_engaged = ($request->engaged_other == "yes") ? true : false;
                $sibir_track_history->user_detail_id = $user->id;
                if ($sibir_track_history->continued) {
                    $sibir_track_history->daily_time = $request->daily_time;
                }

                if( ! empty ($request->start_date) ){
                    foreach ( $request->start_date as $key => $value ){
                         $UserSibirRecord->sibir_start_date_eng = $value;
                         if ( array_key_exists ($key,$request->end_date) ){
                            $UserSibirRecord->sibir_end_date_eng = $request->end_date[$key];
                            $start_date_parse = \Carbon\Carbon::parse($UserSibirRecord->sibir_start_date_eng);
                            $end_date_parse = \Carbon\Carbon::parse($UserSibirRecord->sibir_end_date_eng);
                            $UserSibirRecord->sibir_duration = $start_date_parse->diffInDays($end_date_parse) ?? 1;
                         }
                        $UserSibirRecord->save();
                        $sibir_track_history->user_sibir_record_id  = $UserSibirRecord->id;
                        $sibir_track_history->save();
                    }
                } else {
                    $sibir_track_history->save();
                }

                $user_sadhan_center = new UserSadhanaCenter;
                $user_sadhan_center->user_detail_id = $user->id;
                $user_sadhan_center->center_id = $request->center;
                $user_sadhan_center->reference_type = "sign up";
                $user_sadhan_center->save();
                // $sadhak_entry = new UserSadhakRegistration;
                // $sadhak_entry->user_detail_id = $user->id;
                // $sadhak_entry->is_active  = true;
                // $sadhak_entry->is_new = false;
                // $sadhak_entry->save();
            });
            return redirect($this->generate_signed_url([$user->id,'exist_user'=>true],'sadhana-step-two'));
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            return back()->withErrors(["Something went wrong."])->withInput();
        }
    }


    public function destroy_current_application(Request $request, userDetail $user, $action){
        
        if ( ! $this->delete_only_if_recent() ) {
            // delete only those field that have been recently entered.
        }
        
        if ($action == "close"){

            // let's delete all record from db.
            try {
                \DB::transaction( function () use ($request,$user) {
                    $user->userlogin->delete();
                    $user->delete();
                });
                $request->session()->flush();
                $request->session()->invalidate();
                return redirect()->route('sadhana-registration-one');
            } catch (\Throwable $th) {
                //throw $th;
                dd($th->getMessage());
                return back()->withErrors(["something went wrong."]);
            }
        }
        if ($action == "restart"){

            // let's delete all record from db.
            try {
                \DB::transaction( function () {
                    $user->userlogin->delete();
                    $user->delete();
                    $request->session()->regenerate();
                });
                return redirect()->route('sadhana-registration-one');
            } catch (\Throwable $th) {
                //throw $th;
                return back()->withErrors(["something went wrong."]);
            }
        }

    }

    private function delete_only_if_recent(){
        return true;
    }


    /**admin
     * 
     */

    public function admin_sadahak_registration_list(){


        if (isAdmin()) {

            $users = UserSadhakRegistration::where('is_active',true)
            ->with('userDetail')
            ->get();
            return view('admin.users.sadhak-entry.list',compact('users'));
        }

        if (isCenter()) {
            $users = userDetail::where('country',auth()->user()->userdetail->country)
                                ->where('id','!=',auth()->id())->latest()->get();
            return view('centers.users.sadhak-entry.list',compact('users'));
        }
        abort(403);
    }


    public function participants_list(Request $request) {
        if ( ! isAdmin()) {
            abort(403);
        }

        if ($request->ajax() ) {
            $sibir_record = SibirRecord::findOrFail(request()->sibir);
            $participants = UserSadhakRegistration::where('sibir_record_id',$sibir_record->id)
                            ->with(['userDetail'=>function($query) {
                                return $query->with(["userlogin",'country_name']);
                            }])
                            ->get();
            $datatable = DataTables::of($participants)
                                    ->addColumn("full_name", function ($row) {
                                        if($row->userDetail) {
                                            return $row->userDetail->full_name();
                                        }else {
                                            return "not defined.";
                                        }
                                        
                                        // return ($row->userDetail->full_name());
                                        // return ucwords($row->full_name());
                                    })
                                    ->addColumn('phone_number',function($row){
                                        if ($row->userDetail) {
                                            return $row->userDetail->phone_number;
                                        } else {
                                            return "no defined.";
                                        }
                                        // return $row->userDetail->phone_number;
                                        // return $row->phone_number;
                                    })
                                    ->addColumn('email', function ($row) {
                                        // return $row;
                                        return ($row->userDetail && $row->userDetail->userlogin) ? $row->userDetail->userlogin->email : "email";
                                    })
                                    ->addColumn('address', function ($row) {
                                        return ( $row->userDetail && (int) $row->userDetail->country) ? $row->userDetail->country_name->name : $row->country;
                                        
                                    })
                                    ->addColumn('action', function ($row) {
                                        return "View Detail";
                                    })
                                    ->rawColumns(["action"])
                                    ->make(true);
            return $datatable;
        }


        return view('admin.sadhana.list');
    }

    public function sibir_attendance(Request $request, SibirRecord $sibir){
        if ( ! isAdmin() ) {
            abort(403);
        }
        
        if ($request->ajax()) {

            $all_event_user = UserSadhakRegistration::where('sibir_record_id',$sibir->id)->with(["userDetail"])->paginate(($request->record_per_page) ? $request->record_per_page : 100);
            $event_class = EventVideoClass::where('event_id',$sibir->id)->first();

            $filter_session = VideoClassLog::select(['start_time','id'])
            // ->where("event_video_class_id",$event_class->id)
                                            ->whereBetween('start_time',[$request->from_date,($request->end_date) ? $request->end_date : date("Y-m-d")])
                                            ->get();
            return view('admin.sadhana.attendance_result',compact("filter_session","all_event_user"));
        }
        return view('admin.sadhana.attendance',compact('sibir'));

    }

    public function user_group_list(){
        $sibirs = SibirRecord::get();
        return view("admin.sadhana.group-list",compact('sibirs'));
    }

    public function group_filter_view(Request $request) {
        $groups = UserFamilyGroup::where('sibir_record_id',$request->sibir)
                                    ->where('approved',$request->filter)
                                    ->get();
        return view("admin.sadhana.group-filter",compact('groups'));
    }

    public function change_group_status(Request $request, $status, SibirRecord $sibir, $leader) {

        if ($status == "remove"){
            $family_member = UserFamilyGroup::where('sibir_record_id',$sibir->id)
                                                ->where('leader_id',$leader);
        }
        try {
            if ($status == 'remove') {
                $family_member->delete();
            } else {
                if ($status == "approved") {
                    UserFamilyGroup::where("sibir_record_id",$sibir->id)
                                    ->where('leader_id',$leader)
                                    ->update(["approved"=>true,'approved_by'=>auth()->user()->user_detail_id]);
                }  elseif($status == 'reject') {
                    UserFamilyGroup::where("sibir_record_id",$sibir->id)
                                    ->where('leader_id',$leader)
                                    ->update(["approved"=>false,'approved_by'=>auth()->user()->user_detail_id]);
                }
    
            }
            

        } catch (\Throwable $th) {
            //throw $th;
            if ( $request->ajax() ) {
                return response([
                    "success" => false,
                    'message' => "Error: ". $th->getMessage()
                ]);
            }
            $request->session()->flash('message',"Error: ". $th->getMessage());
            return back();
        }
        if ( $request->ajax() ) {
            return response([
                "success" => true,
                'message' => "Request Completed."
            ]);
        }
        $request->session()->flash('success',"Request Completed.");
        return back();
    

    }

    public function remove_member_from_list(Request $request, $member_id) {
        if ( ! isAdmin() ) {
            abort(403);
        }
        $member = UserFamilyGroup::findOrFail($member_id);

        try {
            $member->delete();
        } catch (\Throwable $th) {
            //throw $th;
            if ( $request->ajax() ) {
                return response([
                    "success" => false,
                    'message' => "Error: ". $th->getMessage()
                ]);
            }
            $request->session()->flash('message',"Error: ". $th->getMessage());
            return back();
        }

        if ( $request->ajax() ) {
            return response([
                "success" => true,
                'message' => "Request Completed."
            ]);
        }
        $request->session()->flash('success',"Request Completed.");
        return back();
    

    }

    public function absent_request() {
        
        if ( ! isAdmin() ) {
            abort(403);
        }

        $sibir_records = SibirRecord::get();
        return view('admin.sadhana.absent_filter_form',compact("sibir_records"));
    }

    public function absent_filter_show(Request $request) {
        if (! isAdmin() ) {
            abort(403);
        }

        $absent_query = EventAbsentRecord::with(['user_detail'])
                                        ->where('sibir_record_id',$request->event);
        if($request->filter != "3"){
            $absent_query->where('status',$request->filter);
        }

        $absent_list = $absent_query->get();

        return view('admin.sadhana.absent_filter.display_result',compact('absent_list'));
    }

    public function change_absent_record(Request $request) {
        $event_detail = EventAbsentRecord::findOrFail($request->absent);
        $event_detail->status = $request->status;

        if ($request->status == 1) {
            $event_detail->absent_approved_by = auth()->user()->user_detail_id;
            $event_detail->absent_approved = 1;
        }

        try {
            $event_detail->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "success" => false,
                "message" => "Error: ". $th->getMessage()
            ]);
        }

        return response([
            "success" => true,
            "message" => "Status Changed. "
        ]);

    }
}
