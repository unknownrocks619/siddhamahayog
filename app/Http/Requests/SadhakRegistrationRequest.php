<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SadhakRegistrationRequest extends FormRequest
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
        return [
            //
            "user_registration" => "required|in:yes,no",
            'gender' => "required_if:user_registration,yes",
            "first_name" => "required_if:user_registration,yes",
            "country" => "required_if:user_registration,yes",
            'city' => "required_with:country",
            'address' => "required_with:city",
            'contact_number' => "required_if:user_registration,yes",
            "emeregency_contact_number" => "required_if:user_registration,yes",
            'education_background' => "required_if:user_registration,yes",
            'profession' => "required_if:user_registration,yes",
            'email_address' => "required|email",
            'date_of_birth' => "required_if:user_registration,yes|date_format:Y-m-d",
            "place_of_birth" => "required_with:date_of_birth",
            'center' => "required_if:user_registration,yes",
            'emeregency_relation' => 'required_if:user_registration,yes',
            'emeregency_full_name' => 'required_if:user_registration,yes'
        ];
    }

    public function messages()
    {
        return [
            'user_registration.in' => "Invalid User Registration Criteria.",
            'user_registration.required' => "You must answer your previous history.",
            'gender.required_if' => "Select Your Gender",
            "first_name.required_if" => "First Name field cannot be empty.",
            "country.required_if" => "You must select your country.",
            'city.required_with' => "Invalid City Selected",
            'address.required_with' => "Invalid address",
            'contact_nuber' => "You must provide your contact number",
            'emeregency_contact_number.required_if' => "You must provide emergency contact number",
            'education_background.required_if' => "Invalid Education Background.",
            "profession.required_if" =>  "Please provide your profession.",
            'email_address.required' => "Please type your email address",
            'email_address.email' => "Invalid Email Address.",
            "date_of_birth.required_if" => "Invalid date format. Proper format is " . date("m/d/Y"),
            'place_of_birth.required_with' => "Please provide your place of birth.",
            'center.required_if' => "You must select center",
            'emeregency_relation.required_if' => "Please Provide your relation with provided emergency Person",
            'emeregency_full_name.required_if' => "Please Provide full name for emergency Person"
        ];
    }
}
