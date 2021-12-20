<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userDetail;
use App\Models\userLogin;
use App\Models\EventFund;
use App\Models\EventFundDetail;
use App\Models\UserSadhakRegistration;
use App\Models\UserSadhanaCenter;
use Faker\Generator as Faker;
use App\Traits\Sms;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Hash;

class ImportExcel extends Controller
{
    //
    use Sms;
    public function index() {
        $row = 1;
        $final_updated_format = [];
        if (($handle = fopen("Binod.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                // echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                $outterArray = [];
                for ($c=0; $c < $num; $c++) {
                    $innerArray=[];
                    // $innerArray[""]
                    if ($c == 0 && ($data[$c] !== "" || $data[$c] != "#N/A")) {
                        $seperate_name = explode(" ",$data[$c]);
                        $outterArray["first_name"] = (isset($seperate_name[0])) ? $seperate_name[0] : $data[$c];
                        $outterArray["middle_name"] = (isset($seperate_name[2])) ? $seperate_name[1] : null;
                        $outterArray["last_name"] = (isset($seperate_name[2])) ? $seperate_name[2] : (isset($seperate_name[1]) ? $seperate_name[1] : null);
                    }
                    if ($c==1 && ($data[$c] !== "" || $data[$c] != "#N/A")) {
                        $outterArray['email'] = strtolower($data[$c]);
                    }

                    if($c==2 && ($data[$c] !== "" && $data[$c] != "#N/A")) {
                        $phone_explode = explode(',',$data[$c]);
                        if( isset($phone_explode[1]) && strlen(trim($phone_explode[1])) >= 10) {
                            $outterArray["phone_number"] = $phone_explode[1];
                        }  else if(isset($phone_explode[0]) && strlen(trim($phone_explode[0])) >= 10) {
                            $outterArray["phone_number"] = trim($phone_explode[0]) ;
                        } else{
                            $outterArray["phone_number"] = ($data[$c]) ? $data[$c] : random_int(0000000000,9999999999);
                        }

                        if ( $outterArray["phone_number"] == null || $outterArray["phone_number"] == "")  {
                            dd($outterArray);
                        }
                        // $outterArray['phone_number'] = (isset($phone_explode[1]) && strlen(trim($phone_explode[1])) >= 10) ? trim($phone_explode[1]) : ();
                        // $outterArray["count"] = (isset($phone_explode[1]) && strlen(trim($phone_explode[1])) >= 10) ? trim($phone_explode[1]) ."-". strlen(trim($phone_explode[1])) : $phone_explode[0] .'-'. strlen($phone_explode[0]);
                    } elseif($outterArray['first_name'] &&  ! isset($outterArray["phone_number"])) {
                        $outterArray["phone_number"] = random_int(0000000000,9999999999);
                    }

                    if ($c == 3 && ($data[$c] !== "" || $data[$c] != "#N/A")) {
                        $outterArray["created_at"] = date("Y-m-d H:i:s" , strtotime($data[$c]));
                    }
                    // $outterArray[] = $innerArray;
                }
                $final_updated_format[] = $outterArray;
            }
            fclose($handle);

        }
        // dd($final_updated_format);
        foreach ($final_updated_format as $output) {
            $old_user = false;
            if ($output["last_name"] == "" && $output["first_name"] ==  ""){
                continue;
            }
            $output["country"] = "Nepal";
            $output["city"] = "";
            $output["user_type"] = "";

            if ( ! $output["first_name"] && ! $outterArray["email"] && ! $output["email"]){
                echo "Hello";
            } else {
                // check if user already exists.
                $user_detail = userDetail::where('phone_number',$output["phone_number"])
                                            ->orWhere('phone_number',"+977".$output["phone_number"])
                                            ->orWhere('phone_number','977'.$output["phone_number"])
                                            ->first();
                $password_code = \Str::random(6);
                if( ! $user_detail ) {
                    $user_detail = userDetail::create($output);
                    $user_login_detail = new userLogin;
                    $user_login_detail->email = $output['email'];
                    $user_login_detail->password = Hash::make($password_code);
                    $user_login_detail->user_type = "public";
                    $user_login_detail->user_detail_id = $user_detail->id;
                    $user_login_detail->verified = null;
                    $user_login_detail->account_status = "Active";
                    $user_login_detail->save();
                } else{
                    $old_user = true;
                    $user_login_detail = userLogin::where('user_detail_id',$user_detail->id)->first();
                    if ( ! $user_login_detail ) {
                        $user_login_detail = new userLogin;
                        $user_login_detail->email = $output['email'];
                        $user_login_detail->password = Hash::make($password_code);
                        $user_login_detail->user_type = "public";
                        $user_login_detail->user_detail_id = $user_detail->id;
                        $user_login_detail->verified = null;
                        $user_login_detail->account_status = "Active";
                        $user_login_detail->save();
                    } else {
                        $user_login_detail->password = Hash::make($password_code);
                    }
                }

                    // old_sadhana = 
                    $old_sadhana = UserSadhanaCenter::where('user_detail_id',$user_detail->id)->first();
                    if (! $old_sadhana){
                        $user_sadhana_center = new UserSadhanaCenter;
                        $user_sadhana_center->user_detail_id = $user_detail->id;
                        $user_sadhana_center->center_id = 7;
                        $user_sadhana_center->reference_type = "Google Form";
                        $user_sadhana_center->confirmed = true;
                        // $user_sadhana_center->status_updated_by = 
                        $user_sadhana_center->save();
                    }

                    $old_entry = UserSadhakRegistration::where('user_detail_id',$user_detail->id)
                                                        ->where('sibir_record_id',1)
                                                        ->first();
                    if ( ! $old_entry ) {
                        $user_sadhak = new UserSadhakRegistration;
                        $user_sadhak->user_detail_id = $user_detail->id;
                        $user_sadhak->is_active = true;
                        $user_sadhak->branch_id = 5;
                        $user_sadhak->user_sadhak_registration_preference_id = $user_sadhana_center->id;
        
                        $user_sadhak->sibir_record_id = 1;
                        $user_sadhak->save();
                    }
                if ( ! $old_user ) {
                    // $this->send_sms_password($user_detail,$user_login_detail);
                }
            }
        }
    }

    public function internationList(){
        $row = 1;
        $final_updated_format = [];
        if (($handle = fopen("IntList.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                // echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                $outterArray = [];
                for ($c=0; $c < $num; $c++) {
                    $innerArray=[];

                    // $innerArray[""]
                    if ($c == 0 && ($data[$c] !== "")) {
                        $outterArray["country"] = $data[$c];
                    }
                    if($c == 1 && $data[$c] !== ""){
                        // $seperate_name = explode(" ",$data[$c]);
                        $outterArray["first_name"] = $data[$c];
                    }
                    if($c == 2 && $data[$c] !== ""){
                        $outterArray["middle_name"] = $data[$c];
                    }
                    if($c == 3 && $data[$c] !== ""){
                        $outterArray["last_name"] = $data[$c];
                    } elseif($c == 3 && $data[$c] == "") {
                        $outterArray["last_name"] = "";
                    }
                    if ($c==4 && ($data[$c] !== "")) {
                        $outterArray['email'] = strtolower($data[$c]);
                    } elseif($c ==4 && $data[$c] == "") {
                        $outterArray["email"] = strtolower(\Str::random(9)."@rgmail.com");
                    }

                    if($c == 5 && $data[$c] !== "") {
                        $outterArray["phone_number"] = $data[$c];
                    } elseif($c==5 && $data[$c] == "") {
                        $outterArray["phone_number"] = null;
                    }

                    if ($c == 6 && $data[$c] != ""){
                        $outterArray["date_of_birth_eng"] = $data[$c];
                    }

                    if($c == 7 && $data[$c] != ""){
                        $outterArray["gender"] = $data[$c];
                    }

                    // $outterArray[] = $innerArray;
                }
                $final_updated_format[] = $outterArray;
            }
            fclose($handle);
        }

        // dd($final_updated_format);


        foreach ($final_updated_format as $output) {
            // $output["country"] = "Nepal";
            $output["city"] = "";
            $output["user_type"] = "";
                $password_code = \Str::random(6);
                // let first verify this user is present or not.
                $user_detail = userDetail::where('phone_number',$output["phone_number"])
                                            ->orWhere('phone_number',"00".$output['phone_number'])
                                            ->orWhere('phone_number',"+".$output["phone_number"])
                                            ->first();
                if( ! $user_detail ) {
                    $user_detail = userDetail::create($output);
                    $user_login = new userLogin;
                    $user_login->email = $output['email'];
                    $user_login->password = Hash::make($password_code);
                    $user_login->user_type = "public";
                    $user_login->user_detail_id = $user_detail->id;
                    $user_login->verified = null;
                    $user_login->account_status = "Active";
                    $user_login->save();
                } else {
                    $user_login = userLogin::where("user_detail_id",$user_detail->id)
                                            ->orWhere('email',$output["email"])
                                            ->first();
                    $check_email = userLogin::where('email',$output["email"])->first();
                    if ( $user_login) {
                        $user_login->password = Hash::make($password_code);
                        $user_login->save();    
                    } elseif($check_email) {
                        // $check_email->user_detail_id
                        $check_email->password = Hash::make($password_code);
                        $check_email->save();
                    } else {
                        $user_login = new userLogin;
                        $user_login->email = $output['email'];
                        $user_login->password = Hash::make($password_code);
                        $user_login->user_type = "public";
                        $user_login->user_detail_id = $user_detail->id;
                        $user_login->verified = null;
                        $user_login->account_status = "Active";
                        $user_login->save();
                    }
                }
                $user_sadhana_center = new UserSadhanaCenter;
                $user_sadhana_center->user_detail_id = $user_detail->id;
                $user_sadhana_center->center_id = 7;
                $user_sadhana_center->reference_type = "Google Form";
                $user_sadhana_center->confirmed = true;
                // $user_sadhana_center->status_updated_by = 
                $user_sadhana_center->save();

                $user_sadhak = new UserSadhakRegistration;
                $user_sadhak->user_detail_id = $user_detail->id;
                $user_sadhak->is_active = true;
                $user_sadhak->branch_id = 5;
                $user_sadhak->user_sadhak_registration_preference_id = $user_sadhana_center->id;

                $user_sadhak->sibir_record_id = 1;
                $user_sadhak->save();
            //                 $message = "<html>";
            //                 $message .= "<body>";
            //                 $message .='<p><strong>आदरणीय गुरुदाजुभाइ तथा दिदिबहिनीहरू,</strong>';
            //                 $message .= '<br />';
            //                 $message .= '<strong>जय श्री सिताराम ।</strong></p>';
            //                 $message .= '<p>परमपूज्य सदगुरुदेवबाट आज औपचारिक रुपमा समुद्घाटन गरि बक्सेको ब्रम्हज्ञान् "अर्थपन्चक" कोर्शमा छनौट भै भर्ना पाउनु भएका सम्पूर्ण भाग्यशाली गुरुदाजुभाइ दिदीबहिनीहरुलाई हार्दिक बधाई।!';
            //                 $message .= "</p>";
            //                 $message .= "<p> यहाहरुलाई यस कोर्श सम्बन्धी निम्न जानकारी गराउन चाहन्छौ:\r\n";
            //                 $message .= "</p><p> Link to participate";
            //                 $message .= "</p><p> https://sadhak.siddhamahayog.org";
            //                 $message .= "<br /> Username: {$user_login->email}";
            //                 $message .= "<br />";
            //                 $message .= "Password: {$password_code}";
            //                 $message .= "</p>";
            //                 $message .= "<p>१. भोलि २५ जुलाई देखि केहि दिन सम्म निम्न समयमा अर्थ पंचक कोर्सको प्रक्रिया बारे जानकारी दिन Orientation Class चल्ने छ।";
            //                 $message .= "";
            //                 $message .= "</p> २. यो orientation class every day exact बिहानको 10am बजे EST क्यानाडा time (7:45pm Nepal time) मा सुरु हुने छ। यसक़ो लागि बिहानको 9:45am बजे Zoom entry खुल्ने छ र १० बज्न ५ मिनट अगाडी नै  entry close हुनेछ। यहाहरु समयमै in हुनुपर्ने छ अन्यथा entry नपाउने डर हुन सक्छ।";
            //                 $message.="</p>";
            //                 $message .= "<p> ३. Orientation session attend गर्न इमेलमा आएको कोड़ प्रयोग गर्नु गर्नुपर्नेछ । Junk mail, spam, promotions मा गयेको पनि हुन सक्छ। कृपया राम्रो संग email check गर्नु होला । एदी कसैले entry log in ID & passcode प्राप्त गर्नु भएको छैन भने तलको नम्बरमा तुरुन्त सम्पर्क गर्नुहोला: +9779852066009.";
            //                 $message .= "</p><p> ४. सबै registered सद्स्यहरु भोलि देखि नै अनिबार्य रुपमा orientation session attend गर्नु पर्ने छ।  यदि आफ्नो काम गर्ने समयका कारण कुनै पनि उपाएले यहाहरु मध्ये कसैलाई उपस्थित हुन नसक्ने अवस्था भएमा हामीलाई तुरुन्त admission@siddhamahayog.org मा खबर गर्नु होला। हामी यसबारे के गर्न सक्छौ परमपूज्य गुरुदेवसंग निबेदन गर्ने छौ।";
            //                 // $message .= "\r\n";
            //                 $message .= "</p>";
            //                 $message .= "<p><strong>भर्ना सेवा युनिट";
            //                 $message .= "<br />";
            //                 $message .= "वेदान्त दर्शन अन्तर्गत अर्थ-पञ्चक कोर्सका लागि";
            //                 $message .= "<br />";
            //                 $message .= "महायोगी सिद्धबाबा अध्यात्मिक प्रतिष्ठान</strong>";
            //                 $message .= "</body>";
            //                 $message .= "</html>";
            //                 $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // // More headers
            // $headers .= 'From: <noreply@siddhamahayog.org>' . "\r\n";
            //                 mail($user_login->email,'Account Created',$message,$headers);


            // $user_login_data = [
            //        "email" => $output["email"],
            //        "password"=> \Hash::make(\Str::random(16)),
            //        "user_type" => "public",
            //        "user_detail_id" => $user_detail->id,
            //        "verified" => false,
            //        "account_status" => "Active",
            //     //    'created_at' => \Carbon\Carbon::now()
            //    ];
            //     //     $output["password"] = \Hash::make(\Str::random(16));
            //     //     $output["user_type"] = "public";
            //     //     $output["user_detail_id"] = $user_detail->id;
            //     //     $output["verified"] = true;
            //     //     $output["account_status"] = "Active";
            //     //     unset($output["created_at"]);
            //     //    dd($output); 
            //     $user_login = userLogin::create($user_login_data);
        }
    }



    public function local_transaction(Request $request){
        $row = 1;
        $final_updated_format = [];
        $event_fund = new EventFund;
        $event_fund_detail = new EventFundDetail;
        $user_detail_instance = new userDetail;

        if (($handle = fopen("monthly.csv", "r")) !== FALSE) {
            $count = 1;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($data[3]) {
                    $num = count($data);
                    // echo "<p> $num fields in line $row: <br /></p>\n";
                    $total_amount = 0;
                    $admission_fee = 9000;
                    $month_fee = [];
                    $row++;
                    $outterArray = [];
                    // get user detail.
                    $user_detail = $user_detail_instance->where('phone_number',$data[3])->first();
                    if ( $user_detail ) {
                        // check for previous record.
                        $fund_exists = $event_fund->where("user_detail_id",$user_detail->id)->first();
                        $total_amount = (float) $data[2];
                        $monthly_fee = 3500;
                        $remaining_fee  =  $total_amount - $admission_fee;
                    
                        if ($fund_exists) {

                            $fund_exists->fund_amount = $fund_exists->fund_amount + (float) $data[2];
                            $fund_exists->save();
                            $event_fund = $fund_exists;
                        } else {        
                            $event_fund = new EventFund;
                            $event_fund->sibir_record_id = 1;
                            $event_fund->user_detail_id = $user_detail->id;
                            $event_fund->user_login_id = $user_detail->userlogin->id;
                            $event_fund->fund_amount = (float) $data[2];
                            // $event_fund->created_at = date("Y-m-d H:i:s",strtotime($data[0]));
                            // $event_fund->updated_at = date("Y-m-d H:i:s",strtotime($data[0]));
                            $event_fund->scholarship = false;
                            try {
                                $event_fund->save();
                            } catch (\Throwable $th) {
                                //throw $th;
                                dd($th->getMessage());
                            }
                        }

                        $admission_transaction = new EventFundDetail;
                        $admission_transaction->user_detail_id = $user_detail->id;
                        $admission_transaction->user_login_id = $user_detail->userlogin->id;
                        $admission_transaction->amount = 9000;
                        $admission_transaction->sibir_record_id = 1;
                        $admission_transaction->event_fund_id = $event_fund->id;
                        $admission_transaction->source = "Cash";
                        $admission_transaction->reference_number = $data[1];
                        $admission_transaction->owner_remarks = "admission fee";
                        $admission_transaction->status = "verified";
                        $admission_transaction->admin_remarks = "admission fee";
                        // $admission_transaction->created_at = date("Y-m-d H:i:s",strtotime($data[0]));
                        // $admission_transaction->updated_at = date("Y-m-d H:i:s",strtotime($data[0]));
                        $admission_transaction->save();
                        echo "<pre>";
                            echo "<h4> {$count} Excel Data</h4>";
                            print_r($data);
                        echo "</pre>";
                        $this->add_fund($remaining_fee,[
                                            "user_detail_id"=>$user_detail->id,
                                            "sibir_record_id"=>1,
                                            "reference_number" => $data[1],
                                            "source" => "Cash",
                                            "event_fund_id" => $event_fund->id,
                                            "user_login_id" => $user_detail->userlogin->id
                        ]);
                        echo "<hr />";
                    } else {
                        echo "User Not Found. - Phone number : " . $data[3]. " - " . $data[2];
                        echo "<br />";
                    }
                    $count++;
                }
                // $count++;
                // if ($count > 2) {
                //     dd("done 2 data");
                // }                
            }
        }

    }
    

    public function add_fund($amount,$data=[],$loop = 1) {
        if ($amount < 3500 ) {
            if ($loop < 3 ) {
                $user_notification = new UserNotification;
                $user_notification->notification_to = $data['user_detail_id'];
                $user_notification->notification_from = 0;
                $user_notification->seen = false;
                $user_notification->notification_type = "Athapanchawk Payment Notification";
                $user_notification->message = "Your Payment is due. To make a payment <a href=''>click here</a>";
                $user_notification->addressable = "\App\Models\userDetail";
                $user_notification->save();
            }
            if ($amount > 0 ) {
                            // add to debit column
                $event_fund_detail = new EventFundDetail;
                $event_fund_detail->user_detail_id = $data["user_detail_id"];
                $event_fund_detail->sibir_record_id = $data["sibir_record_id"];
                $event_fund_detail->amount = $amount;
                $event_fund_detail->source = $data["source"];
                $event_fund_detail->user_login_id = $data["user_login_id"];
                $event_fund_detail->reference_number = $data["reference_number"];
                $event_fund_detail->status = 'verified';
                $event_fund_detail->admin_remarks = "Amount carried over.";
                $event_fund_detail->event_fund_id = $data["event_fund_id"];
                $event_fund_detail->debit = true;
                $event_fund_detail->save();
                // don't need notification    
            }
            return true;
        }
        // add to debit column
        echo "<pre>";
            print_r($data);
        echo "</pre>";
        $event_fund_detail = new EventFundDetail;
        $event_fund_detail->event_fund_id = $data["event_fund_id"];
        $event_fund_detail->user_detail_id = $data["user_detail_id"];
        $event_fund_detail->sibir_record_id = $data["sibir_record_id"];
        $event_fund_detail->amount = 3500;
        $event_fund_detail->source = $data["source"];
        $event_fund_detail->user_login_id = $data["user_login_id"];
        $event_fund_detail->reference_number = $data["reference_number"];
        $event_fund_detail->status = 'verified';
        $event_fund_detail->admin_remarks = "Monthly Fee verified.";
        $event_fund_detail->owner_remarks = "Monthly Fee verified.";
        $event_fund_detail->credit = true;
        $event_fund_detail->save();
        $amount = $amount - $event_fund_detail->amount;
        $loop++;
        return $this->add_fund($amount,$data,$loop);

    }


    public function add_personal_detail() {
        $row = 1;
        $bulk_email = [];
        $updated_count = 1;
        if (($handle = fopen("personal_detail.csv", "r")) !== FALSE) {
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $email = $data[0];
                $education = $data[2];
                $profession = $data[3];
                $profession_in_form = $data[4];
                
                $get_record = \App\Models\userLogin::where('email',$data[0])->with(["userdetail"])->first();

                if ($get_record && $get_record->userdetail) {
                    $get_record->userdetail->education_level = $education;
                    $get_record->userdetail->profession = $profession;
                    $get_record->userdetail->profession_in_form = $profession_in_form;

                    try {
                        $get_record->userdetail->save();
                    } catch (\Throwable $th) {
                        //throw $th;
                        dd($th->getMessage());
                    }
                    $updated_count++;
                }
            }

        }
        echo $updated_count;
        // $check_email = \App\Models\userLogin::whereIn('email',$bulk_email)->with(['userdetail'])->get();
        // foreach ($check_email as $udpate_record)
        // {
        //     if($udpate_record->userdetail) {
        //     }
        // }
    }
}
