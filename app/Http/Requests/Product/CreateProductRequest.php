<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'title_en' => 'required|string' ,
            'summary' => 'nullable|string' ,
            'description' => 'nullable|string' ,
            'category_id' => 'nullable|numeric|exists:product_categories,id' ,

            'variations' => 'nullable|array' ,
            'variations.*.key' => 'required|string' ,
            'variations.*.value' => 'required|string'
        ];
    }
}
