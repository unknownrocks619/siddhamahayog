<?php

namespace App\Http\Controllers\API\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\FeeAPIRequest;
use App\Models\MemberNotification;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeAPIController extends Controller
{
    //

    public function update_fee_status(FeeAPIRequest $request, ProgramStudentFeeDetail $fee_detail)
    {
        $fee_detail->verified =  !$fee_detail->verified;
        $fee_detail->rejected =  !$fee_detail->verified;

        if ($fee_detail->rejected) {
            // $fee_detail->student_fee->total_amount = $fee_detail->student_fee->total_amount - $fee_detail->amount;
        }

        if ($fee_detail->verified) {
            // $fee_detail->student_fee->total_amount = $fee_detail->student_fee->total_amount + $fee_detail->amount;
        }
        try {
            DB::transaction(function () use ($fee_detail) {
                if ($fee_detail->student_fee->isDirty()) {
                    $fee_detail->student_fee->save();
                }
                $fee_detail->save();
            });
        } catch (\Throwable $th) {
            return response([
                "success" => false,
                "message" => "Unable to update fee status.",
                "error" => (auth()->user()->role_id == 1) ? $th->getMessage  : null
            ]);
        }

        if ($fee_detail->verified) {

            $notification =  new MemberNotification;
            $notification->member_id = $fee_detail->student_id;
            $notification->title = "Payment Verified ";
            $notification->notification_type = "App\Models\ProgramStudentFeeDetail";
            $notification->notification_id = $fee_detail->id;
            $notification->body = "Good News ! \n Your payment has been verified. \n Amount : {$fee_detail->amount}";
            $notification->type = "message";
            $notification->level = "notice";
            $notification->seen = false;
            $notification->save();
        }

        if ($fee_detail->rejected) {
            $notification =  new MemberNotification();
            $notification->member_id = $fee_detail->student_id;
            $notification->title = "Payment Verification Failed ";
            $notification->notification_type = "App\Models\ProgramStudentFeeDetail";
            $notification->notification_id = $fee_detail->id;
            $notification->body = "We are sorry to inform you, Your transaction of amount. NRs. " . $fee_detail->amount . " has been rejected. \n\n If you think there is a mistake, Create a ticket explaining your issue.";
            $notification->type = "message";
            $notification->level = "notice";
            $notification->seen = false;
            $notification->save();
        }

        return $this->returnResponse(true,'Fee Information updated.','reload');

    }

    public function delete_fee_transaction(ProgramStudentFeeDetail $fee)
    {
        // check if fee is verified. deduct the amount from overview as well.
        $fee->student_fee->total_amount = $fee->student_fee->total_amount - $fee->amount;
        try {
            DB::transaction(function () use ($fee) {

                if ($fee->student_fee->isDirty()) {
                    $fee->student_fee->save();
                }
                $fee->delete();
            });
        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Unable to remove selected transaction',['error' => $th->getMessage()]);
        }

        return $this->returnResponse(true,'Transaction Deleted.','reload');
    }
}
