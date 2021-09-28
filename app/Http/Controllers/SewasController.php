<?php

namespace App\Http\Controllers;

use App\Models\UserSewa;
use App\Models\Booking;
use App\Models\userDetail;
use App\Models\UserSewaBridge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class SewasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        // dd(Auth::user());
        if( Auth::check()  && Auth::user()->user_type == "admin")
        {
            $page = "admin";
            $data['sewas'] = UserSewa::paginate();
        } 
        return view($page.".sewas.index",$data);
    }

    public function sewa_form(Request $request)
    {
        $data = [];
        if( $request->get('sewa_id') )
        {
            $sewa_detail = UserSewa::find($request->get('sewa_id'));
            $data['sewa'] = $sewa_detail;
        }

        if( Auth::check() && Auth::user()->user_type == "admin")
        {
            $page = "admin";
        }

        return view($page.".sewas.form",$data);

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
       $post = $request->post();
       $post['created_by_user'] = Auth::user()->id;
       $post["slug"] = Str::slug($request->sewa_name, '-');

       $store_response = UserSewa::create($post);
        if ( $request->ajax() ){
            
            if ($store_response){
                return response()->json([
                    'success' => true,
                    'message' => 'New sewa inserted.'
                ]);
            } else {
                return response()->json([
                            'success'=>false,
                            'message' => "Oops ! Something went wrong. Please try again" 
                        ]);
            }
        } else {
            return back()->with('success','New Sewas Added.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SewaModel  $sewaModel
     * @return \Illuminate\Http\Response
     */
    public function show(SewaModel $sewaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SewaModel  $sewaModel
     * @return \Illuminate\Http\Response
     */
    public function edit(SewaModel $sewaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_sewa_service(Request $request)
    {
        //

        $sewaDetail = UserSewa::findOrFail(decrypt($request->__app_id));
        $sewaDetail->sewa_name = $request->sewa_name;
        $sewaDetail->description = $request->description;

        if( $sewaDetail->isDirty()){

            $sewaDetail->save();

            if( $request->ajax() )
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Sewa Detail Updated.'
                ]);
            } else{
                $request->session()->flash('success',"Sewa Detail Updated.");
                return back();
            }

        } else{
            if( $request->ajax() )
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Nothing to update.'
                ]);
            } else{
                $request->session()->flash('success',"Nothing to update.");
                return back();
            }
        }
    }


    public function destroy(Request $request)
    {
        if ($request->__app_id ){
            $sewaDetail = UserSewa::findOrFail(decrypt($request->__app_id));
            // now let's delete.

            $sewaDetail->delete();
            if ($request->ajax())
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully Deleted Sewa.'
                ]);
            } else{
                $request->session()->flash('success',"Selected Sewa was deleted.");
                return back();
            }
        }
        abort(404);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SewaModel  $sewaModel
     * @return \Illuminate\Http\Response
     */
    public function destroy_form(Request $request)
    {
        //
        if ($request->get('sewa_id')){
            
            $sewa_detail = UserSewa::findOrFail(decrypt($request->get('sewa_id')));
            $page = "";
            $data = [];
            if (Auth::check() && Auth::user()->user_type == "admin"){
                $page = "admin";
            }
            $data["sewa"] = $sewa_detail;

            return view($page.'.sewas.delete',$data);

        }
        abort(404);
    }

    public function assign_visitor_to_sewa(Request $request) {
        $post_record = $request->all();
        if ($request->booking_id) {
            $booking_detail = Booking::findOrFail($request->booking_id);
            $post_record["bookings_id"] = $booking_detail->id;
        }

        if ($request->user_id ){
            $user_detail = userDetail::findOrFail($request->user_id);
            $post_record['user_id'] = $user_detail->id;
        }

        // first lets search if for this booking, user is already involved or not.



        $post_record['user_involvement'] = "sewa_involved";
        foreach ($request->sewas as $sewa) {
            $search_sewa = UserSewaBridge::where('user_involvement','sewa_involved')
                            ->where('bookings_id',$booking_detail->id)
                            ->where('user_sewas_id',$sewa)
                            ->first();
            if ( ! $search_sewa){
                $post_record["user_sewas_id"] = $sewa;
                $post_record['created_by_user'] = Auth::guard("admin")->check()  ? Auth::guard("admin")->user()->id : 1;
                UserSewaBridge::create($post_record);
    
            }
        }
        
        return response([
            "success" => true,
            'message' => "User is now providing sewa to ashram."
        ]);
    }
}
