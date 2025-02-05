<?php

namespace App\Http\Requests\Frontend\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentCreateRequest extends FormRequest
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
            'paymentOpt' => ['required', Rule::in(['esewa', 'voucher', 'stripe'])]
        ];
    }

    public function messages()
    {
        return [
            'paymentOpt.required' => 'Please select your mode of payment from selection.',
            'paymentOpt.in' => 'Invalid or payment option not support.'
        ];
    }
}
