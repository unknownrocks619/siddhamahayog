<?php

namespace App\Http\Requests\Frontend\Exam;

use App\Models\UnpaidAccess;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ExamAttendValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && $this->validateUser();
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
        ];
    }

    /**
     * Summary of validateUser
     * @return bool
     */
    public function validateUser(): bool
    {
        return true;
    }
}
