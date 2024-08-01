<?php

namespace App\Http\Requests\BlogCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string' ,
            'description' => 'nullable|string' ,
            'parent.connect' => 'nullable|numeric|exists:blog_categories,id' ,
        ];
    }
}
