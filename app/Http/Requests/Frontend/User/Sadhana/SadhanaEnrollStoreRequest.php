<?php

namespace App\Http\Requests\Frontend\User\Sadhana;

use Illuminate\Foundation\Http\FormRequest;

class SadhanaEnrollStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->checK() ? true : false;
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
            "regural_medicine_history" => "required|in:yes,no",
            "mental_health_history" => "required|in:yes,no",
            "regular_medicine_history_detail" => "required_if:regural_medicine_history,yes",
            "mental_health_history" => "required_if:mental_health_history,yes",
            "practiced_info" => "required|in:yes,no",
            "support_in_need" => "required|in:yes,no",
            "terms_and_condition" => "required|accepted"
        ];
    }
}
