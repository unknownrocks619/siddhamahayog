<?php

namespace App\Http\Requests\Frontend\Program\Diskhay;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //
            "first_name" => "sometimes|required|alpha|min:3",
            "middle_name" => "sometimes|nullable|alpha_dash",
            "last_name" => "sometimes|required",
            "gender" => "sometimes|required|in:male,female",
            "phone_number" => "sometimes|required|min:9|max:11",
            "country" => "sometimes|required|exists:countries,id",
            "state" => "sometimes|required",
            "street_address" => "sometimes|required|min:5",
            "date_of_birth" => "sometimes|required|date|date_format:Y-m-d",
            "place_of_birth" => "sometimes|required",
            "education" => "sometimes|required|in:primary,secondary,higher_secondary,bachelor,master,phd,none",
            "profession" => "sometimes|required_unless:education,primary,secondary",
            "field_of_study" => "sometimes|required_if:education,bachelor,master,phd",
            "emergency_contact_person" => "sometimes|required",
            "emergency_phone" => "sometimes|required|size:10",
            "emergency_contact_person_relation" => "sometimes|required",
            "regural_medicine_history" => "sometimes|required|in:yes,no",
            "mental_health_history" => "sometimes|required|in:yes,no",
            "regular_medicine_history_detail" => "sometimes|required_if:regural_medicine_history,yes",
            "practiced_info" => "sometimes|required|in:yes,no",
            "support_in_need" => "sometimes|required|in:yes,no",
            'rashi_name' => ['sometimes', 'required', Rule::notIn($this->unavilableName())],
            "terms_and_condition" => "sometimes|required|accepted",
            'email' => 'sometimes|required|email',
            'dikshya_type' => 'sometimes|required|in:tulasi,rudrakshya'
        ];
        if (!auth()->check()) {
            $user_rules = [
                'email' => "required|email|unique:members,email",
                'password' => "required|confirmed"
            ];
            $rules = array_merge($rules, $user_rules);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'rashi_name.not_in' => 'Invalid Rashi name.'
        ];
    }

    public function unavilableName()
    {
        return [
            'mesh',
            'aries',
            'taurus',
            'varishabh',
            'gemini',
            'mithuna',
            'cancer',
            'karka',
            'leo',
            'simha',
            'virgo',
            'kanya',
            'libra',
            'tula',
            'scorpio',
            'vrishchik',
            'sagittarius',
            'dhanu',
            'capricorn',
            'makar',
            'aquarius',
            'kumbha',
            'pisces',
            'meena',
            'meen',
            'men',
            'mes',
            'brish',
            'vrish',
            'mithun',
            'mitun',
            'kark',
            'simbha',
            'simma',
        ];
    }
}
