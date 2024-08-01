<?php

namespace App\Http\Requests\ErrorItem;

use Illuminate\Foundation\Http\FormRequest;

class CreateErrorItemRequest extends FormRequest
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
            'title_en' => 'nullable|string' ,
            'summary' => 'nullable|string' ,
            'description' => 'nullable|string' ,
            'error_id' => 'nullable|numeric|exists:errors,id' ,

            'errorCodes' => 'nullable|array' ,
            'errorCodes.*.key' => 'required|string' ,
            'errorCodes.*.value' => 'required|string'
        ];
    }
}
