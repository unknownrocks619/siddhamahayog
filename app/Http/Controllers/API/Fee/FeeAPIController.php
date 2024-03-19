<?php

namespace App\Http\Controllers\API\Fee;

use App\Classes\Helpers\Roles\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\FeeAPIRequest;
use App\Models\MemberNotification;
use App\Models\PermissionUpdate;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeAPIController extends Controller
{
    //

    public function update_fee_status(FeeAPIRequest $request, ProgramStudentFeeDetail $fee_detail)
    {
        $callback = 'reload';
        $params = [];
        if ($request->get('source') == 'datatable' && $request->get('refresh')) {
            $callback = 'ajaxDataTableReload';
            $params['sourceID'] = $request->get('sourceID');
        }


        if ( ! in_array(adminUser()->role(),[Rule::SUPER_ADMIN,Rule::ADMIN])) {

            $oldValue = 'Verified';
            $newValue = 'Verified';
            if ( ! $fee_detail->verified && ! $fee_detail->rejected ) {
                $oldValue = 'Pending';
            } else if(! $fee_detail->verified && $fee_detail->rejected) {
                $oldValue = 'Rejected';
                $newValue = 'Verified';
            } else {
                $newValue = "Rejected";
            }

            $updateRequest = new PermissionUpdate();
            $updateRequest->fill([
                'relation_table' => $fee_detail::class,
                'relation_id'   => $fee_detail->getKey(),
                'request_type'  => PermissionUpdate::REQUEST_UPDATE,
                'status'    => PermissionUpdate::STATUS_PENDING,
                'update_column' => 'transaction_verification',
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'row_old_value' => $fee_detail->toArray(),
                'row_new_value' => $fee_detail->toArray(),
                'update_request_by_user' => adminUser()->getKey(),
                'update_request_by_center' => adminUser()->center_id
            ]);

            $updateRequest->save();
            $params['alert'] = 'swal';
            return $this->json(true,'Your request to update transaction status has been sent.',$callback,$params);
        }

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
            return $this->json(false,'Unable to update fee status.');
//            return response([
//                "success" => false,
//                "message" => "Unable to update fee status.",
//                "error" => (auth()->user()->role_id == 1) ? $th->getMessage  : null
//            ]);
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

        return $this->returnResponse(true,'Fee Information updated.',$callback,$params);

    }

    public function delete_fee_transaction(ProgramStudentFeeDetail $fee)
    {
        $studentFee = $fee->student_fee;

        if ( ! adminUser()->role()->isSuperAdmin() ) {

            $updateRequest = new PermissionUpdate();
            $updateRequest->fill([
                'relation_table' => $fee::class,
                'relation_id'   => $fee->getKey(),
                'request_type'  => PermissionUpdate::REQUEST_DELETE,
                'status'    => PermissionUpdate::STATUS_PENDING,
                'update_column' => 'transaction_delete',
                'old_value' => 'delete',
                'new_value' => 'delete',
                'row_old_value' => $fee->toArray(),
                'row_new_value' => $fee->toArray(),
                'update_request_by_user' => adminUser()->getKey(),
                'update_request_by_center' => adminUser()->center_id
            ]);

            $updateRequest->save();
            $params['alert'] = 'swal';
            return $this->json(true,'Your request to delete transaction has been sent.','reload',$params);
        }

        // check if fee is verified. deduct the amount from overview as well.
//        $fee->student_fee->total_amount = (float) ($fee->student_fee->total_amount ?? 0 )-  (float) $fee->amount;
        try {
            $fee->delete();
        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Unable to remove selected transaction',['error' => $th->getMessage()]);
        }

        $studentFee->reCalculateTotalAmount();
        return $this->returnResponse(true,'Transaction Deleted.','reload');
    }

    public function update_transaction_fee_amount(FeeAPIRequest $request,ProgramStudentFeeDetail $transaction) {

        $request->validate([
            'amount'    => 'required'
        ]);
        $callback = 'reload';
        $params = [];
        if ($request->post('callback') ) {
            $callback = $request->post('callback');
        }

        if ($request->post('params') ) {
            $params = $request->post('params');
        }
        if (! adminUser()->role()->isSuperAdmin() ) {

            $updateRequest = new PermissionUpdate();
            $updateRequest->fill([
                'relation_table' => $transaction::class,
                'relation_id'   => $transaction->getKey(),
                'request_type'  => PermissionUpdate::REQUEST_UPDATE,
                'status'    => PermissionUpdate::STATUS_PENDING,
                'update_column' => 'amount',
                'old_value' => $transaction->amount,
                'new_value' => $request->post('amount'),
                'row_old_value' => $transaction->toArray(),
                'row_new_value' => $transaction->toArray(),
                'update_request_by_user' => adminUser()->getKey(),
                'update_request_by_center' => adminUser()->center_id
            ]);

            $updateRequest->save();
            $params['alert'] = 'swal';
            return $this->json(true,'Your request to update amount information has been sent.',$callback,$params);

        }

        $transaction->amount = $request->post('amount');
        $transaction->save();

        // get sum of current user
        $totalAmount = ProgramStudentFeeDetail::select('amount')
            ->where('program_id',$transaction->program_id)
            ->where('student_id', $transaction->student_id)
            ->where('program_student_fees_id',$transaction->program_student_fees_id)
            ->where('verified',true)
            ->sum('amount');
        $programStudentFee = ProgramStudentFee::find($transaction->program_student_fees_id)->first();

        $programStudentFee->total_amount = $totalAmount;
        $programStudentFee->save();


        return $this->json(true,'Amount Updated.',$callback,$params);
    }


    public function update_transaction_voucher_number(FeeAPIRequest $request, ProgramStudentFeeDetail $transaction) {
        $request->validate([
            'voucher' => 'required'
        ]);
        /**
         * Check if voucher number already exists.
         */
        $exists = ProgramStudentFeeDetail::where('program_id',$transaction->program_id)
                                            ->where('voucher_number',$request->post('voucher'))
                                            ->exists();

        $callback = 'reload';
        $params = [];

        if ($request->post('callback') ) {
            $callback = $request->post('callback');
        }

        if ($request->post('params') ) {
            $params = $request->post('params');
        }

        $params['alert'] = 'swal';
        if ( $exists ) {
            return $this->json(false,'Voucher Already exists.',$callback,$params);
        }


        if (! adminUser()->role()->isSuperAdmin()) {

            $updateRequest = new PermissionUpdate();
            $updateRequest->fill([
                'relation_table' => $transaction::class,
                'relation_id'   => $transaction->getKey(),
                'request_type'  => PermissionUpdate::REQUEST_UPDATE,
                'status'    => PermissionUpdate::STATUS_PENDING,
                'update_column' => 'transaction_voucher_number',
                'old_value' => $transaction->voucher_number,
                'new_value' => $request->post('voucher'),
                'row_old_value' => $transaction->toArray(),
                'row_new_value' => $transaction->toArray(),
                'update_request_by_user' => adminUser()->getKey(),
                'update_request_by_center' => adminUser()->center_id
            ]);

            $updateRequest->save();
            $params['alert'] = 'swal';
            return $this->json(true,'You have requested to update voucher number. Your request has been sent to authorized personal.',$callback,$params);
        }

        $transaction->voucher_number = $request->post('voucher');
        $transaction->save();

        return $this->json(true,'Voucher Updated.',$callback,$params);
    }
}
