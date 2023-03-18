<?php

namespace App\Http\Requests\Frontend\User\Program;

use App\Models\ProgramStudent;
use Illuminate\Foundation\Http\FormRequest;

class VideoAllowedToWatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // return auth()->check() ? true : false;
        return ProgramStudent::where('program_id', $this->program->id)->where('student_id', auth()->id())->exists();
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
