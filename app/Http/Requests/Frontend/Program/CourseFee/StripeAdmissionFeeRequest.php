<?php

namespace App\Http\Requests\Frontend\Program\CourseFee;

use Illuminate\Foundation\Http\FormRequest;

class StripeAdmissionFeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return (auth()->check() && $this->program->students()->where('student_id', auth()->id())->exists()) ?? false;
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
            "amount" => 'required',
            "card_holder_name" => "required|string",
            "payment_method" => "required"
        ];
    }

    public function messages()
    {
        return [
            "amount.required" => "Amount field is required.",
            "card_holder_name.required" => "Please include your name printed on card.",
            "payment_method.required" => "Payment Method is requried."
        ];
    }
}
