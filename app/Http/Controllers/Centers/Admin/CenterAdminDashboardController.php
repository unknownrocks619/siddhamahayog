<?php

namespace App\Http\Controllers\Centers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Center\CenterAdminMemberUpdateRequest;
use App\Models\Member;
use App\Models\MemberInfo;
use App\Models\MemberNotification;
use App\Models\Program;
use App\Models\ProgramStudent;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Upload\Media\Traits\FileUpload;

class CenterAdminDashboardController extends Controller
{
    //
    use FileUpload;
    public function index()
    {
        $members = Member::where('country', '!=', 153)
            // ->where('id', '!=', user()->id)
            ->latest()->get();
        return view('centers.admin.members.list', compact('members'));
    }

    public function memberDetail()
    {
    }

    public function memberEdit(Member $member)
    {
        if ($member->country == 153) {
            session()->flash('error', 'Member Not found.');
            return back();
        }
        return view('centers.admin.members.edit', compact('member'));
    }

    public function memberUpdate(CenterAdminMemberUpdateRequest  $request, Member $member)
    {
        $member->first_name = $request->post('first_name');
        $member->middle_name = $request->post('middle_name');
        $member->last_name = $request->post('last_name');

        $member->full_name = $request->post('first_name') . ($request->post('middle_name')) ? $request->post('middle_name') . " " . $request->post('last_name') : " " . $request->post('last_name');
        $member->country = $request->post('country');
        $member->city = $request->post('state');
        $member->phone_number = $request->post('phone_number');
        $member->address = ['street_address' => $request->post('address')];

        try {
            $member->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to update information: Error: ' . $th->getMessage());
            return back()->withInput();
        }

        session()->flash('success', "Member information Updated.");
        return back();
    }

    public function memberShow(Member $member)
    {
        if ($member->country == 153) {
            session()->flash('error', "Member Not found.");
            return redirect()->route('center.admin.member.show');
        }

        return view('centers.admin.members.show', compact('member'));
    }

    public function memberEnrollStore(Request $request, Member $member)
    {
        $check_user = $member->member_detail()->where('program_id', $request->post('program'))->first();

        if ($check_user) {
            session()->flash('error', 'User is alrady enrolled in program.');
            return back();
        }

        $program = Program::findOrFail($request->post('program'));

        $programEnroll = new ProgramStudent();
        $programEnroll->program_id = $program->getKey();
        $programEnroll->student_id = $member->getKey();
        $programEnroll->active = true;
        $programEnroll->program_section_id = $program->active_sections->getKey();
        $programEnroll->batch_id = $program->active_batch->getKey();

        try {
            $programEnroll->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to enroll user in program. Error: ' . $th->getMessage());
            return back();
        }
        session()->flash('success', 'Program is now enrolled in `' . $program->program_name . '`');
        return back();
    }

    public function storeTransactionDetail(Request $request, Member $member)
    {
        $programStudentFee = ProgramStudentFee::where('program_id', $request->post('program'))
            ->where('student_id', $member->getKey())
            ->first();

        if ($programStudentFee) {

            session()->flash('error', 'Student already paid for the course.');
            return back();
        }

        $programStudentFee = new ProgramStudentFee;
        $programStudentFee->program_id = $request->post('program');
        $programStudentFee->student_id = $member->getKey();
        $programStudentFee->total_amount = $request->post('amount');

        $programStudentFeeDetail = new ProgramStudentFeeDetail();
        $programStudentFeeDetail->program_id = $request->post('program');
        $programStudentFeeDetail->amount_category = "admission_fee";
        $programStudentFeeDetail->amount = $request->post('amount');
        $programStudentFeeDetail->source = "Voucher";
        $programStudentFeeDetail->source_detail = "Voucher Uploaded By " . auth()->user()->full_name;
        $programStudentFeeDetail->verified = false;
        $programStudentFeeDetail->rejected = false;
        $programStudentFeeDetail->student_id = $member->getKey();
        $programStudentFeeDetail->remarks = [
            "upload-date" => $request->post('transaction_date'),
            "bank_name" => "International Center",
        ];
        $programStudentFeeDetail->fee_added_by_user = auth()->id();
        $this->set_access('file');
        $this->set_upload_path('website/payments/programs');
        $programStudentFeeDetail->file = $this->upload('voucher');

        try {
            DB::transaction(function () use ($programStudentFee, $programStudentFeeDetail, $request) {
                $programStudentFee->save();

                $programStudentFeeDetail->program_student_fees_id = $programStudentFee->getKey();
                $programStudentFeeDetail->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to add transaction detail. Error: ' . $th->getMessage());
            return back();
        }
        $notification =  new MemberNotification();
        $notification->member_id = $member->id;
        $notification->title = "Payment Information Updated ";
        $notification->notification_type = "App\Models\Program";
        $notification->notification_id = request()->post('id');
        $notification->body = "Congratulation ! Your admissin fee for has been uploaded by admin.";
        $notification->type = "message";
        $notification->level = "notice";
        $notification->seen = false;

        $notification->save();
        session()->flash('success', 'Payment Added for the user. No further action is required.');
        return back();
    }

    public function storeMemberReference(Request $request, Member $member)
    {
        $meta = $member->meta;

        if ($meta) {
            $meta->remarks = [
                'referer_person' => $request->post('referer_person'),
                'referer_relation' => $request->post('referer_relation'),
                'referer_contact' => $request->post('referer_contact')
            ];

            $meta->save();
            session()->flash('success', 'Member Reference Detail updated.');
            return back();
        }
        $meta = new MemberInfo();
        $meta->education = [
            'education' => "",
            'education_major' => null,
            'profession' => null
        ];
        $meta->member_id = $member->getKey();
        $meta->remarks =  [
            'referer_person' => $request->post('referer_person'),
            'referer_relation' => $request->post('referer_relation'),
            'referer_contact' => $request->post('referer_contact')
        ];

        try {
            $meta->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', 'Unable to save changes. Error: ' . $th->getMessage());
            return back();
        }

        session()->flash('success', "Reference Detail updated.");
        return back();
    }
}
