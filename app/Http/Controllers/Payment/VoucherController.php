<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Payment\StoreVoucherUploadRequest;
use App\Models\Program;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Upload\Media\Traits\FileUpload;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    use FileUpload;
    public function store(StoreVoucherUploadRequest $request, Program $program)
    {
        dd($request->file('voucherPhoto', true));
        $this->set_access('file');
        $this->set_upload_path('website/payments/programs');

        $fee_type = ($program->student_admission_fee) ? 'monthly_fee' : 'admission_fee';
        $programStudentFee = ProgramStudentFee::where('student_id', auth()->id())->where('program_id', $program->id)->first();
        if (!$programStudentFee) {
            $programStudentFee = new ProgramStudentFee;
            $programStudentFee->program_id = $program->id;
            $programStudentFee->student_id = auth()->id();
            $programStudentFee->total_amount  = $program->active_fees->$fee_type;
        }
        $programStudentFeeDetail  = new ProgramStudentFeeDetail;
        $programStudentFeeDetail->program_id = $program->id;
        $programStudentFeeDetail->student_id = auth()->id();
        $programStudentFeeDetail->amount = $program->active_fees->$fee_type;
        $programStudentFeeDetail->amount_category = $fee_type;
        $programStudentFeeDetail->source = 'Voucher Upload';
        $programStudentFeeDetail->source_detail = 'Physical Bank Deposit';
        $programStudentFeeDetail->verified = false;
        $programStudentFeeDetail->remarks = ['upload_date' => $request->post('voucher_date'), 'bank_name' => $request->post('bank_name')];
        $programStudentFeeDetail->file = $this->upload('voucherPhoto');

        try {
            DB::transaction(function () use ($programStudentFeeDetail, $programStudentFee) {
                if ($programStudentFee && $programStudentFee->isDirty()) $programStudentFee->save();
                $programStudentFeeDetail->program_student_fees_id = $programStudentFee->id;
                $programStudentFeeDetail->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", 'Unable to upload your voucher at the moment.');
            return back()->withInput();
        }
        session()->flash("success", 'Your Voucher has been uploaded. Please wait until we verify your payment detail.');
        return redirect()->route('user.account.programs.courses.fee.list', $program->id);
    }
}
