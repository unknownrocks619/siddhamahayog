<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userDetail;
use Illuminate\Support\Facades\Hash;
use App\Traits\Upload;
use Nepali;

class PublicUserProfileController extends Controller
{
    use Upload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_detail = userDetail::findOrFail(auth()->user()->user_detail_id);
        return view("public.user.profile.index",compact('user_detail'));
    }

    public function password(){
        $user_detail = userDetail::findOrFail(auth()->user()->user_detail_id);
        return view('public.user.profile.password',compact("user_detail"));
    }

    public function personal(){
        $user_detail = userDetail::findOrFail(auth()->user()->user_detail_id);
        return view("public.user.profile.personal",compact("user_detail"));
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

    public function personal_setting_store(Request $request) {
        $request->validate([
            'first_name' => "required|string",
            "last_name" => "required|string",
            "phone_number" => "required",
            "date_of_birth" => "required",
            "gender" => "required|in:male,female,other",
            "country" => "required|numeric|exists:countries,id",
            "city" => "required|numeric|exists:cities,id",
            "address" => "required"
        ]);

        $user_detail = userDetail::find(auth()->user()->user_detail_id);
        if ( ! $user_detail) {
            $request->session()->flash('message',"Your profile is incomplete or not configured properly. Please contact Support.");
            return back();
        }
        
        $user_detail->first_name = $request->first_name;
        $user_detail->last_name = $request->last_name;
        $user_detail->gender = $request->gender;
        
        // let check if this phone number is already in use.
        $check_phone = userDetail::where('phone_number',$request->phone_number)
                                    ->where('id', "!=",$user_detail->id)
                                    ->first();
        
        if ($check_phone) {
            $request->session()->flash('message',"Provided Phone already exists in system. Please Use another number.");
            return back();
        }

        $user_detail->phone_number = $request->phone_number;
        $user_detail->date_of_birth_eng = $request->date_of_birth;

        // lets conver to nepali date.
        $nepali_class = new Nepali;

        $nep_date = $nepali_class->get_nepali_date(
                    date("Y",strtotime($request->date_of_birth)),
                    date("m",strtotime($request->date_of_birth)),
                    date("d",strtotime($request->date_of_birth))
        );
        $date_of_birth_nepali = $nep_date["y"].'-'.$nep_date['m'].'-'.$nep_date['d'];
        $user_detail->date_of_birth_nepali = $date_of_birth_nepali;
        $user_detail->country = $request->country;
        $user_detail->city = $request->city;
        $user_detail->address = $request->address;
        // dd($user_detail);
        try {
            $user_detail->save();
        } catch (\Throwable $th) {
            $request->session()->flash('message',"unable to complete your request. Please try again.");
            return back()->withInput();
        }

        $request->session()->flash("success","User Information has been udpated.");
        return back();
    }

    public function public_change_password(Request $request) {
        $request->validate([
            'old_password' => "required",
            'password' => "required|confirmed|min:6"
        ]);

        $user_login_detail = auth()->user();
        
        // lets check old password.
        if (Hash::check($request->old_password,$user_login_detail->password) ) {
            $user_login_detail->password = Hash::make($request->password);

            try {
                $user_login_detail->save();
            } catch (\Throwable $th) {
                //throw $th;
                $request->session()->flash('p_error',"Oops, Something went wrong.");
                return back();
            }
            $request->session()->flash('p_success',"Password Changed.");
            return back();
        } 

        $request->session()->flash("p_error","Your old password didn't match our record.");
        return back();


    }

    public function update_profile_picture(Request $request){
        $request->validate([
            "upload" => "required|mimes:png,jpg,gif,jpeg|mimetypes:image/*"
        ]);

        $user_detail = userDetail::findOrFail(auth()->user()->user_detail_id);
        // dd($this->upload($request,"upload"));
        $user_detail->profile_id = $this->upload($request,"upload")->id;

        try {
            $user_detail->save();
        } catch (\Throwable $th) {
            $request->session()->flash('pro_error',"Unable to upload file.");
            return back();
        }
        \Cache::store('file')->forget('u_d');
        \Cache::store('file')->put('u_d',$user_detail);
        $request->session()->flash('pro_success',"Profile picture updated.");
        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
