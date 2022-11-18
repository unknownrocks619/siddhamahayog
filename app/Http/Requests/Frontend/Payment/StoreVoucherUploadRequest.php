<?php

namespace App\Http\Requests\Frontend\Payment;

use App\Models\ProgramStudent;
use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->check()) {
            return false;
        }
        if (!ProgramStudent::where('active', true)->where('program_id', $this->program->id)->where('student_id', auth()->id())->exists()) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'amount' => 'required',
            'payment_type' => "required",
            'bank_name' => "required|string|in:Garima Bikas Bank",
            "voucher_date" => "required|date|date_format:Y-m-d",
            "voucherPhoto" => "required|image|mimes:png,jpg,gif,jpeg|max:2048"
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => "all fields are mandatory.",
            'bank_name.required' => "Bank name is required.",
            'bank_name.string' => "Valid bank name is required",
            'bank_name.in' => 'Only Garima Bikas Bank is supported at the moment.',
            'payment_type.required' => "all fields are mandatory.",
            'voucher_date.required' => "all fields are mandatory.",
            'voucher_date.date' => "Plese select date as per your voucher.",
            'voucher_date.date_format' => "Please select date.",
            'voucher_date.mimes' => "Only png, jpg, gif and Jpeg image extension are supported.",
            'voucherPhoto.max' => "Voucher Image file should be less 2MB"
        ];
    }
}
