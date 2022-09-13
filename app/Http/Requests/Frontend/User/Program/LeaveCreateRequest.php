<?php

namespace App\Http\Requests\Frontend\User\Program;

use App\Models\ProgramStudent;
use Illuminate\Foundation\Http\FormRequest;

class LeaveCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->check()) return false;

        // check if user is enrolled in give progam.
        if (!ProgramStudent::where('program_id', $this->program->id)->where('student_id', auth()->id())->exists()) return false;

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
