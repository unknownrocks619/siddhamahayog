<?php

namespace App\Http\Requests\Admin\Page;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            "page_name" => "required|unique:pages,page_name",
            // "page_description" => "nullable",
            "page_type" => "required|in:terms,standard,gallery,about-us,contact-us,team,project-single,course,video,home",
            "display_option" => "required|in:public,admin,parent,auth,student,org",
            "featured_image" => "nullable|mimes:png,jpg,jpeg,gif",
            "add_widget" => "nullable"
        ];
    }
}
