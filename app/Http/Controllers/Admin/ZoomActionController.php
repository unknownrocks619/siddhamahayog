<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventVideoClass;
use App\Models\userDetail;
use App\Models\userLogin;
use App\Models\SadhakUniqueZoomRegistration;
use App\Models\UserSadhakRegistration;
use Illuminate\Support\Facades\DB;

class ZoomActionController extends Controller
{
    //

    public function index() {
        return view('admin.zoom.meeting');
    }

    public function generate_link($meeting_id,$sadhak=null,$user_id = null) {
        if ( $user_id ) {
            $user_detail = userDetail::findOrFail($user_id);
            $user_login = userLogin::where('user_detail_id',$user_detail->id)->first();

            $data = [
                "first_name" => $user_detail->first_name,
                'last_name' => $user_detail->last_name,
                "email" => ($user_login->email) ? $user_login->email : "noemail{$user_detail->id}@gmail.com"
            ];
            
            // dd($to_object);
            //make
            $to_object = $this->zoom_link($data); 
            if ( ! $to_object ){

                dd("Error Generating Link: " . $err);
            }
            $zoom_link_set = new  SadhakUniqueZoomRegistration;
            $zoom_link_set->join_link = $to_object->join_url;
            $zoom_link_set->registration_id = $to_object->registrant_id;
            $zoom_link_set->user_detail_id = auth()->user()->user_detail_id;
            $zoom_link_set->have_joined = false;
            $zoom_link_set->joined_at = false;
            $zoom_link_set->sibir_record_id = ($sadhak) ? $sadhak : 1;
            $zoom_link_set->meeting_id = $meeting_id;
            // $zoom_link_set->
            try {
                $zoom_link_set->save();
            } catch (\Throwable $th) {
                //throw $th;
                dd("Error: ". $th->getMessage());
                session()->flash('message',"Error Generating Link: ". $th->getMessage());
                return back();
            }
            dd("link generated.");
            session()->flash('success',"Link Generated for user ." . $user_detail->full_name());
            return back();
        }




        // $getAllUser = UserSadhakRegistration::where('sibir_record_id',$sadhak)
        //                                     ->with(['userDetail'=>function($query){
        //                                         return $query->with(['userlogin']);
        //                                     }])
        //                                     ->get();

        $offlimitcontd = 1;
        $bulk_record = [];
        $skip_record = [];  
        $users =  DB::table('user_sadhak_registrations')
                    ->join('user_details','user_sadhak_registrations.user_detail_id' ,'=','user_details.id')
                    ->join('user_logins','user_details.id' ,'=','user_logins.user_detail_id')
                    // ->select(["user_sadhak_registrations.*","user_detail.first_name",'user_details.last_name','user_detail.id'])
                    ->orderBy("user_sadhak_registrations.id")
                    ->chunk(25,function($getAllUser) use($skip_record,$bulk_record,$offlimitcontd,$meeting_id,$sadhak) {
                        foreach ($getAllUser as $register_user){
                            $innerArray = [];
                                $data = [
                                    "first_name" => $register_user->first_name,
                                    "last_name" => $register_user->last_name,
                                    "email" => "testuser{$register_user->user_detail_id}@gmail.com"
                                    // "email" => ($register_user->userlogin && $register_user->userDetail->userlogin->email) ? $register_user->userDetail->userlogin->email : "noemail{$register_user->id}@gmail.com"
                                ];
                                $zoom_response = $this->zoom_link($data,$meeting_id);
                    
                                if (! $zoom_response ) {
                                    $skip_record[] = $register_user->id;
                                } else {
                                    $innerArray = [
                                        'join_link' => $zoom_response->join_url,
                                        'registration_id' => $zoom_response->registrant_id,
                                        'user_detail_id' => $register_user->userDetail->id,
                                        'have_joined' => false,
                                        'joined_at' => true,
                                        'sibir_record_id'=> $register_user->sibir_record_id,
                                        'meeting_id' => $meeting_id,
                                        "created_at" => \Carbon\Carbon::now()
                                    ];
                                    $bulk_record[] = $innerArray;
                                    $offlimitcontd++;
                                }                            
                
                        }
                    });
        
        if ($bulk_record) {
            try {
                //code...
                dd($bulk_record);
            } catch (\Throwable $th) {
                //throw $th;
                dd($th->getMessage());
            }
        }
    }

    private function zoom_link($user_data=[],$meeting_id) {
        $signature = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6InBVQmhpSkRqVFJXaG9XQWVuamttTFEiLCJleHAiOjE2MjkwODAyNjQsImlhdCI6MTYyODk5Mzg2NX0.BYwDmUodqz83ejkMaMnzDxfBVs_jPSMU277sYWvbkXs";
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/meetings/{$meeting_id}/registrants",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($user_data),
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$signature}",
                "content-type: application/json"
            ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ( $err ) {
                return false;
            }
            return json_decode($response);
    }
}
