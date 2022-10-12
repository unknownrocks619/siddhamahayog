<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
            "category_name" => "required",
            "slug" => "required|unique:categories,slug," . $this->category->id,
            "description" => "nullable",
            "category_type" => "required|in:general,gallery,lms,video,book_upload_category",
            "parent_id" => "nullable|exists:categories,id"
        ];
    }
}
