<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SadhanaMentalQueriesRequest extends FormRequest
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
            "is_alone" => "required|in:yes,no",
            "relative_name" => "required_if:is_alone,no",
            "relative_relation" => "required_with:relative_name",
            "first_visit" => "required|in:yes,no",
            'physical_difficulties' => "required|in:yes,no",
            'health_problem_description' => "required_if:physical_difficulties,yes",
            'mental_health' => "required|in:yes,no",
            "mental_problem_description" => "required_if:mental_health,yes",
            "support_yes" => "required|in:yes,no",
            'terms_and_condition' => "required|accepted",
            "relative_relation_contact" => "required_if:is_alone,no"
        ];
    }

    public function messages(){
        return [
            'is_alone.required' => "You must specify your status",
            'is_alone.in' => "Select Your option",
            "is_alone.in" => "Invalid Selection",
            "relative_name.required_if" => "You must provide your relative name",
            'relative_relation.required_with' => "You must specify your relation with your relative",
            'first_visit.required' => "speicify your visit status",
            'physical_difficulties.required' => "Please specify if you have any physical or health problem",
            'health_problem_description.required_if' => "You must describe your health problem",
            'mental_health.required' => "Please provide your mental health status",
            'mental_problem_description.required_if' => "Please describe your mental health problem",
            'support_yes.required' => "Will you support us in future ?",
            'terms_and_condition.accepted' => 'You must agree to our terms and condition.',
            'relative_relation_contact.required_if' => "Please provide contact number you are with."
        ];
    }
}
