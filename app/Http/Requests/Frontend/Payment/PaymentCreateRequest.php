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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'paymentOpt' => ['required', Rule::in(['esewa', 'voucher'])]
        ];
    }

    public function messages()
    {
        return [
            'paymentOpt.required' => 'Please select your mode of payment from selection.',
            'paymentOpt.in' => 'Please select your mode of payment from selection.'
        ];
    }
}
