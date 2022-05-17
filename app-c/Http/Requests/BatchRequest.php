<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
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
        $validation = [
            
        ];
        if ($this->batch && $this->batch->id) {
         return [
            "batch_name" => "required",
            "year" => "required|date_format:Y",
            "month" => "required|date_format:m",
            "slug" => ['sometimes','required',"alpha_dash",Rule::unique('batches')->ignore($this->batch->id)]
         ];   
        } else {
            return [
                "batch_name" => "required",
                "year" => "required|date_format:Y",
                "month" => "required|date_format:m",
             ];
        }
    }
}
