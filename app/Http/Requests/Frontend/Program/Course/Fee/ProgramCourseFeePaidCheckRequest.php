<?php

namespace App\Http\Requests\Frontend\Program\Course\Fee;

use App\Models\ProgramStudent;
use Illuminate\Foundation\Http\FormRequest;

class ProgramCourseFeePaidCheckRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->check()) return false;

        if ($this->program) {
            if (!ProgramStudent::where('program_id', $this->program->id)->where('student_id', user()->id)->exists()) return false;
        }

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
        ];
    }
}
