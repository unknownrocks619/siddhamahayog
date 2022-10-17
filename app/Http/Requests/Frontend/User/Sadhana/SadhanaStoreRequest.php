<?php

namespace App\Http\Requests\Frontend\User\Sadhana;

use App\Rules\GoogleCaptcha;
use Illuminate\Foundation\Http\FormRequest;

class SadhanaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() ? true : false;
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
            "first_name" => "required|alpha|min:3",
            "middle_name" => "nullable|alpha_dash",
            "last_name" => "required",
            "gender" => "required|in:male,female",
            "phone_number" => "required|size:10",
            "country" => "required|exists:countries,id",
            "state" => "required",
            "street_address" => "required|min:5",
            "date_of_birth" => "required|date|date_format:Y-m-d",
            "place_of_birth" => "required",
            "education" => "required|in:primary,secondary,higher_secondary,bachelor,master,phd,none",
            "profession" => "required_unless:education,primary,secondary",
            "field_of_study" => "required_if:education,bachelor,master,phd",
            "emergency_contact_person" => "required",
            "emergency_phone" => "required|size:10",
            "emergency_contact_person_relation" => "required",
            "recaptcha_token" => ["required", new GoogleCaptcha()],
        ];
    }
    public function messages()
    {
        return [
            "first_name.required" => "First Name is required.",
            "first_name.alpha" => "First name can only contain alphabhet characters.",
            "middle_name.aplha_dash" => "Invalid character in middle name.",
            "last_name.required" => "Last Name is required",
            "gender.required" => "Provide your gender",
            "gender.in" => "Invalid gender. Please select proper gender format.",
            "phone_number.required" => "Phone number is required.",
            "phone_number.numeric" => "Please include only numbers.",
            "phone_number.max" => "Invalid Phone number.",
            "country.required" => "Country field is required.",
            "country.exists" => "Please select proper country.",
            "state.required" => "State field is required",
            "street_address.required" => "Street address is required.",
            "street_address.min" => "Invalid street address",
            "date_of_birth.required" => "Date of birth is required",
            "date_of_birth.date" => "Date of birth is required",
            "date_of_birth.date_format" => "Invalid Date format. Accepted Format: YYYY-MM-DD",
            "place_of_birth.required" => "Your birth place is required.",
            // "place_of_birth.exists" => "Select your birth place.",
            "education.required" => "Your education background is required. ",
            "education.in" => "Please select proper education background.",
            "profession.required" => "Please provide your profession.",
            "field_of_study.required_if" => "Your education major is required.",
            "emergency_contact_person.required" => "Emergency Contact person field is required",
            "emergency_phone.required" => "Provide Emergency contact person phone number ",
            "emergency_phone.numeric" => "Please include only numbers.",
            "emergency_phone" => "Invalid Phone number.",
            "emergency_contact_person_relation.reation" => "Your relation with the person.",

        ];
    }
}
