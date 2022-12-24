<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberEmergencyMeta;
use App\Models\MemberInfo;
use App\Models\ProgramStudent;
use App\Models\Sadhak\SadhakMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserConverterController extends Controller
{
    //

    public function convertProcess(SadhakMember $user)
    {
        // check if this user is already in list.
        if (!$user->email || Str::contains($user->email, ['fake', 'mailinator', 'example', 'guest', ''])) {
            return response(
                [
                    'message' => 'Invalid Email Address. Please update your email address before migration.',
                    'redirect' => true,
                    'url' => ''
                ],
                406
            );
        }

        // also check if this user is already registered or not.
        $member = Member::where('email', $user->email)->first();

        if (!$member) {
            return $this->UserDetail($user);
        }

        $member->source = 'sadhak_portal';
        $member->external_source_id = $user->getKey();

        // also check if this sadhak is already registered ?

        $programEnrollment = ProgramStudent::where('student_id', $member->getKey())->where('program_id', 2)->first();

        try {
            DB::transaction(function () use ($member, $programEnrollment) {
                $member->save();
                if (!$programEnrollment) {

                    $enrollUser = new ProgramStudent();
                    $enrollUser->program_id = 2;
                    $enrollUser->student_id = $member->getKey();
                    $enrollUser->batch_id = 1;
                    $enrollUser->program_section_id = 1;
                    $enrollUser->save();
                }
            });
        } catch (\Throwable $th) {
            //throw $th;
            return response(['message' => "Unable to compmlete migration.", 406]);
        }

        return response(['message' => "Congratulation ! Your information has been migrated to system.", 200]);
    }


    public function UserDetail(SadhakMember $sadhak)
    {
        $member = new Member();
        $member->first_name = trim(ucwords(strip_tags($sadhak->first_name)));
        $member->middle_name = trim(ucwords(strip_tags($sadhak->middle_name)));
        $member->last_name = trim(ucwords(strip_tags($sadhak->last_name)));

        $full_name = trim(ucwords(strip_tags($sadhak->first_name)));

        if (trim(ucwords(strip_tags($sadhak->middle_name)))) {
            $full_name .= " ";
            $full_name .= trim(ucwords(strip_tags($sadhak->middle_name)));
        }

        $full_name .= " ";
        $full_name .= trim(ucwords(strip_tags($sadhak->last_name)));

        $member->full_name = $full_name;

        $member->source = "sadhak_portal";
        $member->external_source_id = $sadhak->getKey();
        $member->gende = $sadhak->gender;
        $member->country = $sadhak->country;
        $member->phone_number = $sadhak->phone_number;
        $member->city = $sadhak->city;
        $member->role_id = 7;
        $member->email = $sadhak->user_login->email;
        $member->password = $sadhak->user_login->password;
        $member->sharing_code = Str::uuid();
        $member->address = $sadhak->address;
        //
        $emmergencyContact = new MemberEmergencyMeta;


        $emmergencyContact->contact_person = $sadhak->emergency_contact_name;
        $emmergencyContact->relation = $sadhak->relation_with_emergency_contact;
        $emmergencyContact->phone_number = $sadhak->emergency_contact;

        $memberInfo = new MemberInfo;
        $education = [
            'education' => $sadhak->education_level,
            'education_major' => null,
            'profession' => $sadhak->profession
        ];
        $memberInfo->educaction = $education;

        $programEnrollment = new ProgramStudent();

        $programEnrollment->program_id = 2;
        $programEnrollment->program_section_id = 2;
        $programEnrollment->batch_id = 1;
        $programEnrollment->active = 1;

        try {
            DB::transaction(function () use ($memberInfo, $emmergencyContact, $member, $sadhak, $programEnrollment) {
                $member->save();

                if ($sadhak->emergency_contact) {
                    $emmergencyContact->member_id = $member->id;
                }

                $memberInfo->member_id = $member->id;
                $emmergencyContact->save();
                $memberInfo->save();

                $programEnrollment->student_id = $member->id;
            });
        } catch (\Throwable $th) {
            //throw $th;
            return response(['message' => 'Something Went wrong during transfer. Please try again.'], 406);
        }

        return response([
            'message' => "Account Transfer Success.",
            'redirect' => true,
            'uri' => ''
        ], 200);
    }
}
