<?php

namespace App\Http\Controllers\Frontend\Program;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Program\Diskhay\StoreAuthRequest;
use App\Models\Member;
use App\Models\MemberDikshya;
use App\Models\MemberEmergencyMeta;
use App\Models\MemberInfo;
use App\Models\Program;
use App\Models\ProgramStudent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class DiskhyaController extends Controller
{
    //
    protected $_id = 3;
    public function index()
    {
        return view('frontend.page.dikshya.index', ['programID' => $this->_id]);
    }


    public function store(StoreAuthRequest $request, $set = 'first')
    {
        if (!auth()->user()) {
            $set = 'first';
        }
        return $this->storeAuth($request, $this->_id, $set);
    }

    public function storeAuth(Request $request, int $programID, $set = 'first')
    {
        $unicode_character = check_unicode_character($request->all());
        if ($unicode_character) {
            return back()->withErrors($unicode_character)->withInput();
        }

        if ($set === 'first') {

            $user = new Member();

            $user->first_name = $request->post('first_name');
            $user->middle_name = $request->post('middle_name');
            $user->last_name = $request->post('last_name');

            $full_name = $request->post('first_name');

            if ($request->post('middle_name')) {
                $full_name .= " ";
                $full_name .=  $request->post('middle_name');
            }

            $full_name .= " ";
            $full_name .= $request->post('last_name');
            $user->full_name = $full_name;

            $user->source = "portal";
            $user->gender = $request->post('gender');
            $user->country = $request->post('country');
            $user->city = $request->post('state');
            $user->address = ['street_address' => $request->post('street_address')];
            $user->date_of_birth = $request->post('date_of_birth');

            $user->email = $request->post('email');
            $user->password = Hash::make($request->post('password'));
            $user->phone_number = $request->post('phone_number');
            $user->role_id = 7;
            $user->sharing_code = Str::uuid();


            $history = [
                "medicine_history" => $request->regural_medicine_history,
                "mental_health_history" => $request->mental_health_history,
                "regular_medicine_history_detail" => $request->regular_medicine_history_detail,
                "mental_health_detail_problem" => $request->mental_health_detail_problem,
                "practiced_info" => $request->practiced_info,
                "support_in_need" => $request->support_in_need,
                "terms_and_condition" => $request->terms_and_condition,
                "sadhak" => $request->user_sadhak
            ];

            $personal = [
                "date_of_birth" => $request->date_of_birth,
                "place_of_birth" => $request->place_of_birth,
                "street_address" => $request->street_address,
                "state" => $request->state,
                "gender" => $request->gender
            ];


            $education = [
                "education" => $request->education,
                "education_major" => $request->post('field_of_study'),
                "profession" => $request->profession
            ];



            $userInfo = new MemberInfo();
            $userInfo->history = $history;
            $userInfo->personal = $personal;
            $userInfo->education = $education;

            if ($request->referer_person) {
                $remarks = [
                    "referer_person" => $request->referer_person,
                    "referer_relation" => $request->referer_relation,
                    "referer_contact" => $request->referer_contact
                ];
                $userInfo->remarks = $remarks;
            }

            $emergency_contact = new MemberEmergencyMeta();
            $emergency_contact->contact_person = $request->emergency_contact_person;
            $emergency_contact->relation = $request->emergency_contact_person_relation;
            $emergency_contact->phone_number = $request->emergency_phone;

            try {
                DB::transaction(function () use ($user, $userInfo, $emergency_contact) {
                    $user->save();
                    $userInfo->member_id = $user->getKey();
                    $userInfo->save();
                    $emergency_contact->member_id = $user->getKey();
                    $emergency_contact->save();
                });
            } catch (\Throwable $th) {
                dd($th->getMessage());
                session()->flash('error', 'Unable to create new record.');
                return back()->withInput();
            }
            Auth::login($user);
            session()->flash('success', 'Congratulation ! Your basic information has been saved Please complete below form to proceed.');
            return back();
        }

        if ($set === 'two') {
            $user = user();
            if ($request->rashi_name) {
                $dikshya_detail = new MemberDikshya;
                $dikshya_detail->rashi_name = $request->post('rashi_name');
                $dikshya_detail->member_id = $user->getKey();
                $dikshya_detail->save();
            }
            // also save other detial.
            $program = Program::find($this->_id);
            return $this->stepTwo($request, $program);
        }

        if ($set === 'three') {
            $user = user();
            if (session()->has('current_diksha')) {
                $diksha = MemberDikshya::where('member_id', $user->getKey())->find(session()->get('current_diksha'));
            } else {
                $diksha = $user->diskshya()->latest()->first();
            }
            $program = Program::find($this->_id);
            return $this->stepThree($request, $diksha, $program);
        }


        abort(404);
    }

    protected function stepTwo(Request $request, Program $program)
    {

        $history = [
            "medicine_history" => $request->regural_medicine_history,
            "mental_health_history" => $request->mental_health_history,
            "regular_medicine_history_detail" => $request->regular_medicine_history_detail,
            "mental_health_detail_problem" => $request->mental_health_detail_problem,
            "practiced_info" => $request->practiced_info,
            "support_in_need" => $request->support_in_need,
            "terms_and_condition" => $request->terms_and_condition,
            "sadhak" => $request->user_sadhak
        ];

        $personal = [
            "date_of_birth" => $request->date_of_birth,
            "place_of_birth" => $request->place_of_birth,
            "street_address" => $request->street_address,
            "state" => $request->state,
            "gender" => $request->gender
        ];


        $education = [
            "education" => $request->education,
            "education_major" => $request->post('field_of_study'),
            "profession" => $request->profession
        ];

        $userInfo = new MemberInfo();
        $userInfo->history = $history;
        $userInfo->personal = $personal;
        $userInfo->education = $education;

        if ($request->referer_person) {
            $remarks = [
                "referer_person" => $request->referer_person,
                "referer_relation" => $request->referer_relation,
                "referer_contact" => $request->referer_contact
            ];
            $userInfo->remarks = $remarks;
        }


        $emergency_contact = new MemberEmergencyMeta();
        $emergency_contact->member_id = user()->getKey();
        $emergency_contact->contact_person = $request->emergency_contact_person;
        $emergency_contact->relation = $request->emergency_contact_person_relation;
        $emergency_contact->phone_number = $request->emergency_phone;



        $user = user();

        $userDikshya = new MemberDikshya();
        $userDikshya->member_id = $user->getKey();
        $userDikshya->rashi_name = $request->rashi_name;


        $DiskshyaProgram = Program::with(["active_batch", "active_fees", "active_sections"])->where('status', "active")->where('id', $this->_id)->first();
        try {
            DB::transaction(function () use ($request, $user, $DiskshyaProgram, $userInfo, $emergency_contact) {
                /**
                 * History
                 */
                if (!$user->meta) {
                    $userInfo->member_id = $user->getKey();
                    $userInfo->save();
                } else {

                    $userInfo = $user->meta;
                    $history = [
                        "medicine_history" => $request->regural_medicine_history ?? (isset($userInfo->history->medicine_history) ? $userInfo->history->medicine_history : null),
                        "mental_health_history" => $request->mental_health_history ?? (isset($userInfo->history->mental_health_history) ? $userInfo->history->mental_health_history : null),
                        "regular_medicine_history_detail" => $request->regular_medicine_history_detail ?? (isset($userInfo->history->regular_medicine_history_detail) ? $userInfo->history->regular_medicine_history_detail : null),
                        "mental_health_detail_problem" => $request->mental_health_detail_problem ?? (isset($userInfo->history->regular_medicine_history_detail) ? $userInfo->history->regular_medicine_history_detail : null),
                        "practiced_info" => $request->practiced_info ?? (isset($userInfo->history->practiced_info) ? $userInfo->history->practiced_info : null),
                        "support_in_need" => $request->support_in_need ?? (isset($userInfo->history->support_in_need) ? $userInfo->history->support_in_need : null),
                        "terms_and_condition" => $request->terms_and_condition ?? (isset($userInfo->history->terms_and_condition) ? $userInfo->history->terms_and_condition : null),
                        "sadhak" => $request->user_sadhak ?? (isset($userInfo->history->sadhak) ? $userInfo->history->sadhak : null)
                    ];
                    $personal = [
                        "date_of_birth" => $request->date_of_birth ?? $userInfo->personal->date_of_birth,
                        "place_of_birth" => $request->place_of_birth ?? $userInfo->personal->place_of_birth,
                        "street_address" => $request->street_address ?? $userInfo->personal->street_address,
                        "state" => $request->state ?? $userInfo->personal->state,
                        "gender" => $request->gender ?? (isset($user->personal->gender) ? $user->personal->gender : 'male')
                    ];


                    $education = [
                        "education" => $request->education ?? $userInfo->education->education,
                        "education_major" => $request->post('field_of_study') ?? $userInfo->education->education_major,
                        "profession" => $request->profession ?? $userInfo->education->profession
                    ];

                    if ($request->referer_person) {
                        $remarks = [
                            "referer_person" => $request->referer_person ?? $userInfo->remarks->referer_person,
                            "referer_relation" => $request->referer_relation ?? $userInfo->remarks->referer_relation,
                            "referer_contact" => $request->referer_contact ?? $userInfo->remarks->referer_contact
                        ];
                        $userInfo->remarks = $remarks;
                    }

                    $userInfo->history  = $history;
                    $userInfo->personal = $personal;
                    $userInfo->education = $education;
                    $userInfo->save();
                }
                /**
                 * Emergency Contact Information.
                 */
                if (!$user->emergency) {
                    $emergency_contact->save();
                } else {
                    $meta = $user->emergency;
                    $meta->contact_person = $request->emergency_contact_person ??  $meta->contact_person;
                    $meta->relation = $request->emergency_contact_person_relation ?? $meta->relation;
                    $meta->phone_number = $request->emergency_phone ?? $meta->phone_number;
                    $meta->save();
                }

                if (!$DiskshyaProgram || !$DiskshyaProgram->active_batch  || !$DiskshyaProgram->active_sections) {
                    session()->flash('error', 'OOPS ! Unable to update information.');
                    return back()->withInput();
                }

                if (ProgramStudent::where('student_id', auth()->id())->where('program_id', $DiskshyaProgram->id)->exists()) {

                    session()->flash('error', 'Your is already updated');
                    return back();
                }


                // check if we have information about diksya type.
                if ($user->diskshya && $request->rashi_name && $request->dikshya_type) {

                    $checkDiskhayStatus = $user->diskshya()->where('dikshya_type', $request->post('dikshya_type'))->first();

                    if (!$checkDiskhayStatus) {

                        $dikshay = $this->insertDikshaForm([
                            'member_id' => $user->getKey(),
                            'rashi_name' => $request->post('rashi_name'),
                            'dikshya_type' => $request->post('dikshya_type'),
                        ]);

                        session()->put('current_diksha', $dikshay->getKey());
                    }
                } elseif ($request->rashi_name && $request->dikshya_type) {
                    $dikshay = $this->insertDikshaForm([
                        'member_id' => $user->getKey(),
                        'rashi_name' => $request->post('rashi_name'),
                        'dikshya_type' => $request->post('dikshya_type'),
                    ]);
                    session()->put('current_diksha', $dikshay->getKey());
                }
            });
        } catch (\Throwable $th) {
            dd($th->getMessage());
            session()->flash('error', 'Oops ! Something went wrong. Please try again later.');
            return back()->withInput();
        }

        session()->flash('success', 'Congratulation ! One more step to go.');
        return back();
    }


    public function stepThree(Request $request, MemberDikshya $diksha, Program $program)
    {

        $diksha->remarks = ['terms' => $request->terms_and_condition];

        $programStudent = new ProgramStudent();
        $programStudent->program_id = $program->getKey();
        $programStudent->student_id = auth()->id();
        $programStudent->batch_id = $program->active_batch->id;
        $programStudent->program_section_id = $program->active_sections->id;
        $programStudent->active = true;

        try {
            DB::transaction(function () use ($diksha, $programStudent, $program) {
                $diksha->save();
                if (!ProgramStudent::where('student_id', user()->getKey())->where('program_id', $program->getKey())->exists()) {

                    $programStudent->save();
                }
            });
        } catch (Exception $ex) {
            session()->flash('error', 'Unable to update your information.');
            return back()->withInput();
        }

        return back();
    }

    public function insertDikshaForm(array $record): Model
    {
        $dikshaForm = new MemberDikshya;
        $dikshaForm->fill($record);
        $dikshaForm->save();
        return $dikshaForm;
    }
}
