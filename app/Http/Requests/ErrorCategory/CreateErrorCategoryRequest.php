<?php

namespace App\Http\Requests\ErrorCategory;

use Illuminate\Foundation\Http\FormRequest;

class CreateErrorCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string' ,
            'name_en' => 'nullable|string' ,
        ];
    }
}
