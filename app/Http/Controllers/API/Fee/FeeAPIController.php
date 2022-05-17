<?php

namespace App\Http\Controllers\API\Fee;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\FeeAPIRequest;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeAPIController extends Controller
{
    //

    public function update_fee_status(FeeAPIRequest $request , ProgramStudentFeeDetail $fee_detail) {
        if ($request->update_type) {
            $fee_detail->verified =  ! $fee_detail->verified;
            $fee_detail->rejected =  ! $fee_detail->verified;

            if ($fee_detail->rejected) {
                $fee_detail->student_fee->total_amount = $fee_detail->student_fee->total_amount - $fee_detail->amount;
            } 
            
            if($fee_detail->verified) {
                $fee_detail->student_fee->total_amount = $fee_detail->student_fee->total_amount + $fee_detail->amount;

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
        } else {

        }

        return response([
            "success" => true,
            "message" => "Fee Detail updated."
        ]);
    }

    public function delete_fee_transaction(ProgramStudentFeeDetail $fee) {
        // check if fee is verified. deduct the amount from overview as well.

        if ($fee->verified) {
            $fee->student_fee->total_amount = $fee->student_fee->total_amount - $fee->amount;
        }

        try {
            DB::transaction(function () use ($fee) {
                if ($fee->student_fee->isDirty()) {
                    $fee->student_fee->save();
                }
                $fee->delete();
            });
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "success" => false,
                "message" => "Unable to remove data.",
                "error" => $th->getMessage()
            ]);
        }

        return response([
            "success" => true,
            "message" => "Record Deleted.",
        ]);
    }
}
