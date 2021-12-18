<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\userLoginRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

use App\Models\userDetail;
use App\Models\UserLogin;
use App\Models\UserTypes;
use App\Models\UserVerification;
use App\Models\userMedia;
use App\Models\userReference;
use App\Models\UserSewaBridge;
use App\Models\DonationTransaction;
use App\Models\Donation;
use App\Models\Night;
use App\Models\Booking;
use Illuminate\Support\Facades\App;

use Nepali;
use DataTables;

use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{

    protected $redirectTo = '/';


    /**
     * list all users data.
     */
    public function get_user_list(Request $request)
    {
        $getResponse = userDetail::select('id','first_name','middle_name','last_name','phone_number','pet_name');

        if ($request->get('q'))
        {
            $getResponse->where('first_name','LIKE','%'.$request->get('q').'%');
            $getResponse->orWhere('middle_name','LIKE','%'.$request->get('q').'%');
            $getResponse->orWhere('last_name','LIKE','%'.$request->get('q').'%');
            $getResponse->orWhere('phone_number','LIKE','%'.$request->get('q').'%');
            $getResponse->orWhere('pet_name','LIKE','%'.$request->get('q').'%');
        }
        $response = ['results'=>[]];
        foreach ($getResponse->get() as $list_response)
        {
            $innerArray = [];
            $innerArray['id'] = $list_response->id;
            $arrange = $list_response->first_name;
            if($list_response->middle_name)
            {
                $arrange .= " ";
                $arrange .= $list_response->last_name;
            }
            $arrange .= " (";
            $arrange .= $list_response->phone_number . ")";
            $innerArray['text'] = $arrange;
            $response['results'][] = $innerArray;
        }
        return response($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ( Auth::check())
        {
            //$users = userDetail::chunk(300, function ($result) {
             //   return $result;
            //});
            // if ($request->ajax())  {
            //     $users_table = userDetail::with(["country_name",'city_name']);

            //     $users = $users_table->get();
            //     $datatable = DataTables::of($users)
            //                 // ->addIndexColumn()
            //                 ->addColumn('full_name',function ($row) {
            //                     $link = "<a href='".route('users.view-user-detail',$row->id)."'>";
            //                         $link .= $row->full_name();
            //                     $link .= "</a>";
            //                     return $link;
            //                     // return ucwords($row->full_name());
            //                 })
            //                 ->addColumn("address",function ($row) {
            //                     return ((int)$row->country) ? $row->country_name->name : $row->country;
            //                 })
            //                 ->addColumn('phone_number',function ($row){
            //                     return $row->phone_number;
            //                 })
            //                 ->addColumn('gender', function ($row) {
            //                     return ucwords($row->gender);
            //                 })
            //                 ->addColumn('profession', function ($row) {
            //                     return ucwords($row->profession);
            //                 })
            //                 ->addColumn('action', function ($row) {
            //                     $action = "";
            //                         $action .= "<a href='".route('users.edit_user_detail',$row->id)."'>";
            //                             $action .= "Edit";
            //                         $action .= "</a>";
            //                     return $action;
            //                 })
            //                 ->rawColumns(['full_name','action'])
            //                 ->make(true);
            //     return $datatable;
            // }
                $users = userDetail::with(["country_name"])->get();
            return view('admin.users.list_org',compact("users"));
        }
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
     * @param  \App\Models\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function show(userDetail $userDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(userDetail $userDetail)
    {
        //
        $user_types = UserTypes::get();
        return view('admin.users.edit',compact('userDetail','user_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, userDetail $userDetail)
    {
        //
        if ($request->dob_eng){
        // let's convert date to english
        $date_of_birth_nepali = $request->date_of_birth_nepali;
        $nepali_class= new Nepali;
        $explode = explode('-',$request->date_of_birth_nepali);
        $eng_date = $nepali_class->get_eng_date($explode[0],$explode[1],$explode['2']);
        $date_of_birth_eng = $eng_date['y'] . '-'.$eng_date['m'].'-'.$eng_date['d'];
        } else {
            $date_of_birth_eng = $request->date_of_birth_nepali;
            $nepali_class = new Nepali;
            $nep_date = $nepali_class->get_nepali_date(
                                date("Y",strtotime($request->date_of_birth_nepali)),
                                date("m",strtotime($request->date_of_birth_nepali)),
                                date("d",strtotime($request->date_of_birth_nepali))
            );
            $date_of_birth_nepali = $nep_date["y"].'-'.$nep_date['m'].'-'.$nep_date['d'];
        }

        $userDetail->fill($request->except('date_of_birth_nepali') + [
            'date_of_birth_nepali' => $date_of_birth_nepali,
            'date_of_birth_eng' => $date_of_birth_eng
        ]);
        if ( $userDetail->save()){
            $request->session()->flash("success","User Record has been updated");
        } else {
            $request->session()->flash("error","Unable to update user record. Please try again...");
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(userDetail $userDetail)
    {
        //
    }



    /**
     * just verify login post with db
     */
     public function verify_login_post(userLoginRequest $request)
     {
 

         // now let's autheticate
         // $credentials = ['email']
         if(Auth::attempt(
                 [
                     'email'=>$request->email_address,
                     'password'=>$request->password,
                     'user_type' => $request->route,
                     'account_status' => "Active"
                 ]
             )
          ){
            $request->session()->regenerate();
            Session::put('roles',auth()->user()->userRoles->id);
            
            if (isAdmin()) {
                return redirect()->intended(route('admin_dashboard'));
            }

            if (isCenter() ) {
                return redirect()->intended(route('center_dashboard'));
            }
            abort(403);
         }
         return back()->withErrors(['email'=>"Credentials do not match our records."]);
 
     }

    // Admin Setup

    /**
     * Show login form for users / admin
     * 
     * @param \Illuminate\Http\Response
     */
    public function ad_login(Request $request)
    {

        if (Str::contains($request->route()->getPrefix(),"admin")){
            $prefix = "admin";
        }  else{
            $prefix = "user";
        }
        return $this->template('users/login',['route'=>$request->route()->getPrefix(),'route'=>$prefix],$prefix);
    }


    /**
     * Show login form for users / admin
     * 
     * @param \Illuminate\Http\Response
     */
    public function center_ad_login(Request $request)
    {
        return view('centers.users.login');
    }

    public function ad_user_detail(Request $request,userDetail $id, $type = null)
    {
        $data = [
            'user_detail' => $id
        ];
        $page = ($type) ? $type : "detail";


        switch ($type) {
            case 'sewas':
                // fetch all involved sewas along with booking dates.
                $involved_sewas = UserSewaBridge::where('user_id',$id->id)
                ->where('user_involvement','sewa_involved')
                ->get();
                $data["involved_sewas"] = $involved_sewas;
            break;
            case 'donations':
                $don_transactions = DonationTransaction::where('user_detail_id',$id->id)->get();
                $donation = Donation::where('user_detail_id',$id->id)->first();
                $data["don_transactions"] = $don_transactions;
                $data['donation'] = $donation;
            break;
            case 'nights':
                $bookings = Booking::where('user_detail_id',$id->id)->get();
                $data["bookings"] = $bookings;
            break;
            case "verification":
                $verification = UserVerification::where('user_detail_id',$id->id)->first();
                $data["verifications"] = $verification;
            break;
            case "medias":
                $medias = userMedia::where('user_detail_id',$id->id)->get();
                $data["medias"] = $medias;
            break;
            default:
                $page = "detail";
                break;
        }

        
        return view('admin.users.'.$page,$data);
    }

    /**
     * Show user registration form
     * 
     * @param \Illuminate\Http\Response
     * 
     */
    public function new_user(Request $request)
    {
        // dd(Auth::guard('admin'));
        $user_type = UserTypes::get();
        $data['user_types'] = $user_type;
        if (Auth::check())
        {
            if ($request->get('step') && $request->get('step') == "two")
            {
                $page = 'register-step-2';
                $user_id = $request->get('user_id');

                if (! $user_id )
                {
                    dd("Invalid Request");                    
                }
                $user_detail = userDetail::find(decrypt($request->get('user_id')));
                $data['user_detail'] = $user_detail;
            } else if ($request->get('step') && $request->get('step') == "three") {
                $page = "register-step-3";
                $data["user_detail"] = userDetail::findOrFail(decrypt($request->get('user_id')));
            } else if($request->get('step') && $request->get('step') === 'four') {
                $page = "register-step-4";
                $data['user_detail'] = userDetail::findOrFail(decrypt($request->get('user_id')));
            } else{
                $page = 'register';
            }

            return view('admin.users.'.$page,$data);
        }
    }

    public function submit_registration(Request $request)
    {
        
        $db_post_request = $request->post();

        // dd($request->all());
        if ($request->dob_eng) {
            // let's convert date to english
            $db_post_request["date_of_birth_nepali"] = $request->date_of_birth_nepali;
            $nepali_class= new Nepali;
            $explode = explode('-',$request->date_of_birth_nepali);
            $eng_date = $nepali_class->get_eng_date($explode[0],$explode[1],$explode['2']);
            $db_post_request["date_of_birth_eng"] = $eng_date['y'] . '-'.$eng_date['m'].'-'.$eng_date['d'];
        } else {
            $db_post_request["date_of_birth_eng"] = $request->date_of_birth_nepali;
            $nepali_class = new Nepali;
            $nep_date = $nepali_class->get_nepali_date(
                                date("Y",strtotime($request->date_of_birth_nepali)),
                                date("m",strtotime($request->date_of_birth_nepali)),
                                date("d",strtotime($request->date_of_birth_nepali))
            );
            $db_post_request["date_of_birth_nepali"] = $nep_date["y"].'-'.$nep_date['m'].'-'.$nep_date['d'];
        }

        if (Auth::check() )
        {
            $db_post_request['created_by_user'] = Auth::user()->id;
        }

        $userController = new userDetail;
        // dd($db_post_request);
        $createRecord = $userController->create($db_post_request);
        if($createRecord )
        {
            // current id;
            $user_inserted_id = $createRecord->id;


            // dd($createRecord->id);
            if($db_post_request['email'])
            {
                $this->store_random_login($user_inserted_id,$db_post_request['email'],'Hold');
                // $userLogin = new userLogin;
                // $user_login_instance['email'] = $db_post_request["email"];
                // $user_login_instance['password'] = Hash::make(Str::random(8));;
                // $user_login_instance['account_status'] = "Hold";
                // $user_login_instance['created_by_user'] = Auth::user()->id;
                // $user_login_instance['user_detail_id'] = $user_inserted_id;
                // $user_login_instance['user_type'] = 'visitor';
                // $userLogin->create($user_login_instance);
            }

            // act according to user entry type.
            if (Auth::check() )
            {
                return redirect()->route('users.new_user_registration',['step'=>"two",'user_id'=>encrypt($user_inserted_id)]);
            }
        }

    }

    public function submit_user_verification(Request $request)
    {
        $userDetail = UserDetail::findOrFail(decrypt($request->get('user_id')));

        if ($request->pet_name)
        {
            $userDetail->pet_name = $request->pet_name;
            $userDetail->save();
        }
        $post_content = $request->post();
        $path = ($request->file('document_file')->store('avatars'));
        $file = $request->file('document_file');
        $file_detail = [
            "path" => $path,
            'orignal_name' => $file->getClientOriginalName(),
            'extension' => $file->extension(),
        ];
        $post_content["document_file_detail"] = json_encode($file_detail);
        $post_content['user_detail_id'] = $userDetail->id;
        $post_content['verification_type'] = $request->document_type;

        if ( $request->post('gaurdian_search') )
        {
            // let's get user detail from search.
            $gaurdianSearch = UserDetail::findOrFail($request->post('gaurdian_search'));

            $full_name = $gaurdianSearch->first_name;
            if($gaurdianSearch->middle_name){
                $full_name .= " ";
                $full_name .= $gaurdianSearch->middle_name;
            }
            $full_name .= " ";
            $full_name .= $gaurdianSearch->last_name;

            $post_content['parent_name'] = $full_name;
            $post_content['parent_phone'] = $gaurdianSearch->phone_number;
            $post_content['parent_id'] = $gaurdianSearch->id;
        } else {
            $post_content['parent_name'] = $request->post('gaurdian_name');
            $post_content['parent_phone'] = $request->gaurdian_phone;
    
        }

        if (Auth::check() )
        {
            $post_content['created_by_user'] = Auth::user()->id;
            $post_content["verified"] = true;
        }

        // $verificationModel = new 
        UserVerification::create($post_content);

        // act according to user entry type.
        if (Auth::check() )
        {
            return redirect()->route('users.new_user_registration',['step'=>"three",'user_id'=>encrypt($userDetail->id)]);
        }
    }

    public function store_webcam_upload(Request $request)
    {
        $user_detail = userDetail::find(decrypt($request->user_id));

        // let's search current active and change it to null;
        $currentActiveMedia = userMedia::where(['user_detail_id'=>$user_detail->id,'active'=>true])->first();
        if ($currentActiveMedia != null)
        {
            $currentActiveMedia->active = false;
            $currentActiveMedia->save();
        }

        // let's create new one.
        $db_post = [
            'created_by_user' => Auth::user()->id,
            'user_detail_id' => $user_detail->id,
            'active' => true,
        ];

        // let's upload first.

        if ($request->file('webcam')->isValid()){

            // dd($request->file('webcam')->path());
            $path = Storage::putFile('profiles',$request->file('webcam')->path());
            $db_post['image_url'] = $path;
            $image_property = [
                "orignam_name" => $request->webcam->getClientOriginalName(),
                'extension' => $request->webcam->extension(),
                'hash_name' => $request->webcam->hashName()
            ];
            $db_post["image_property"] = json_encode($image_property);

            $new_media  = userMedia::create($db_post);

            if ($new_media->id)
            {
                return response()->json([
                    'error' => false,
                    'message' => "Snapshot was saved successfully. Please wait while you are redirect.",
                    'redirection' => url("admin/register"). "?step=four&user_id=".encrypt($user_detail->id)
                ]);
                // return redirect()->route('users.new_user_registration',['step'=>"four",'user_id'=>encrypt($user_detail->id)]);
            }
        }
    }

    public function save_sewa_reference(Request $request)
    {
        
        $user_detail = userDetail::findOrFail(decrypt($request->user_id));
        // user refernces content.
        $post_record = $request->post();
        
        if(Auth::check()){
            $post_record['created_by_user'] = Auth::user()->id;
        }
        $post_record["user_detail_id"] = decrypt($request->user_id);

        // check if reference is given in number or string.

        // also let's check if this user already entereed.

        $reference_detail = userReference::where('user_detail_id',$user_detail->id)->get()->first();
        if ( ! $reference_detail ):
            
            if ((int) $request->refered_by_person) {
                // let's search this user and get its detail.

                $refered_user_detail = userDetail::findOrFail($request->refered_by_person);
                $post_record["name"] = $refered_user_detail->full_name();
                $post_record['phone_number'] = $refered_user_detail->phone_number;
                $post_record['user_referer_id'] = $refered_user_detail->id;
            } else {
                $post_record['name'] = $request->refered_by_person;
            }
            
            if ( (int) $request->refered_branch_id ){
                $post_record["center_id"] = $request->refered_branch_id;
            }

            userReference::create($post_record);
        endif;
        

        if ( ! empty ($request->interested_sewa) ) 
        {
            $insert_bulk = [];
            foreach ( $request->interested_sewa as $list_sewa ) 
            {
                $innerArray = [];
                if (Auth::check() ) {
                    $innerArray["created_by_user"] = Auth::user()->id;
                }
                $innerArray['user_sewas_id'] = $list_sewa;
                $innerArray['user_involvement'] = 'sewa_interested';
                $innerArray['user_id'] = $user_detail->id;
                $insert_bulk[] = $innerArray;
                UserSewaBridge::create($innerArray);
            }
        }

        // now let's save if any skills is present.
        if ($request->skills) {
            $user_detail->skills = $request->skills;
            $user_detail->save();
        }

        // now redirect user to either to provide login detail or book a room.
        $request->session()->flash('success','New User Record has been created.');
        if ($request->make_booking) {
            return redirect()->route('bookings.ad-new-booking',['user_id'=>encrypt($user_detail->id)]);
        } 
        return redirect()->route('users.user-list');

    }

    /**
     * Store new email to bd if none was provided during registration 
     * @param Request $request 
     * @return json
     * @
     */
    public function store_new_email(Request $request) 
    {
        $user_detail = userDetail::findOrFail($request->user_id);
        $response = [];

        // let's check if record exists.
        if ($user_detail->userlogin && $user_detail->userlogin->email) {
            $response =['success'=>false,'message'=>'This account already have an email account associated with it.'];
        } elseif ( ! $user_detail->userlogin || ! $user_detail->userlogin->email) {

            // let's add new email address to user, also let's add other required fields.
            $saved_email = $this->store_random_login($user_detail->id,$request->email,'Hold');
            
            if ( ! $saved_email ){
                $response = ['success'=>false,'message'=>"Email Already Exists."];
            } else{
                $response = ['success'=>true,'message'=>'Congratulation, You just added email address.']; 
            }
        } else{
            $response = ['success'=>false,'message'=>'Oops, Something went wrong please try again.'];
        }
        // if($request->ajax()){
            return response($response);
        // }
    }

    
    /**
     * During registration or while inserting new email address only
     * we create other random values to required field
     * @param int $user_detail_id primary key from table user_detail
     * @param String $account_status Account status Hold | Active | Unverified
     * @return userLogin Instance
     * @access admin
     * @version 1.0
     */
    protected function store_random_login($user_detail_id,$email,$account_status="Hold")
    {
        $userLogin = new userLogin;

        // let's check if email already exists.
        $check_email = $userLogin::where('email',$email)->first();
        if ($check_email){
            return null;
        }

        $user_login_instance['email'] = $email;
        $user_login_instance['password'] = Hash::make(Str::random(8));;
        $user_login_instance['account_status'] = $account_status;
        $user_login_instance['created_by_user'] = Auth::user()->id;
        $user_login_instance['user_detail_id'] = $user_detail_id;
        $user_login_instance['user_type'] = 'visitor';
        return $userLogin->create($user_login_instance);
    }

    /**
     * Update Alias or Pet name for the user.
     * @param Request $request
     * @return json
     * @access "admin"
     */
    public function update_pet_name(Request $request)
    {
        $user_detail = userDetail::findOrFail($request->user_id);
        $response = [];
        
        $user_detail->pet_name = $request->pet_name;

        if($user_detail->save())
        {
            $response = ['success'=>true,'message'=>"Pet Name Updated."];
        } else{
            $response = ['success'=>false,'message'=>'Oops, Something went wrong, Please try again.'];
        }

        // if ($request->ajax()){
            return response($response);
        // }
    }

    /**
     * Update users Marital Staus
     * @param Request $request
     * @access 'admin'
     */
    public function update_marital_status(Request $request)
    {
        $user_detail = userDetail::findOrFail($request->user_id);
        $response = [];
        if ($request->married_to)
        {
            $user_detail->married_to_id = $request->married_to;
        } else{
            // let's find out the user
            $existing_user = userDetail::findOrFail($request->married_to_existing);
            $user_detail->married_to_id = $existing_user->id;
            $existing_user->married_to_id = $user_detail->id;
            $existing_user->marritial_status = "Married";
            $existing_user->save();
        }
        $user_detail->marritial_status = "Married";

        if($user_detail->save()) {
            $response = [
                'success' => true,
                'message' => "Congratulation, You just Added Marrital Status of User."
            ]; 
        } else {
            $response = [
                'success'=> false,
                'message' => "Oops, Unable to update user marital status. Please Try again."
            ];
        }

        // if($request->ajax()){
            return response($response);
        // }
    }



    public function sadhana_registration_form(){
        if (! request()->session()->get('locale') ) {
            return redirect('locale');
        }
        App::setLocale(request()->session()->get('locale'));    
        return view('public.user.sadhana.sadhana-registration');
    }

    public function sadhana_registration_submit(\App\Http\Requests\SadhakRegistrationRequest $request){
        dd($request->all());
    }


    public function public_user_login_form(){
        return view('public.user.auth.login-updated');
    }

    public function public_login_using_phone(Request $request){
        $credentials = $request->validate([
            'username' => "required|string",
            'password' => "required|min:6"
        ]);
        $is_email=filter_var($request->username,FILTER_VALIDATE_EMAIL);
        if ($is_email ){
            if( auth()->attempt(['email'=>$is_email,'password'=>$request->password])) {
                Cache::store('file')->put('u_l',auth()->user());
                Cache::store("file")->put('u_d',auth()->user()->userdetail);
                return redirect()->route('public_user_dashboard');
            } else{
                return back()->withErrors(["user"=>"Invalid User ID or Password."]);
            }
        }
        // fetch detail using phone 
        $user_detail = UserDetail::where("phone_number",$request->username)
                                    ->first();
        if ( ! $user_detail ) {
            return back()->withErrors(["user"=>"Invalid User ID or Password."]);
        }

        if( Hash::check($request->password,$user_detail->userlogin->password)) {
            auth()->loginUsingId($user_detail->userlogin->id);
                Cache::store('file')->put('u_l',auth()->user(),2880);
                Cache::store("file")->put('u_d',$userdetail,2880);
            return redirect()->route('public_user_dashboard');
        }
        return back()->withErrors(["user"=>"Invalid User ID or Password."]);
    }

    public function public_user_dashboard(){
        if( ! \Cache::store('file')->has('u_l') || !\Cache::store('file')->has('u_d') ) {
            return redirect()->route('public_user_login')->withErrors(["Authorization Required."]);
        }
        return view('public.user.dash');
    }
}   



