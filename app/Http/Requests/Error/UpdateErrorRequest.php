<?php

namespace App\Http\Requests\Error;

use App\Rules\UniqueErrorCategoryName;
use Illuminate\Foundation\Http\FormRequest;

class UpdateErrorRequest extends FormRequest
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
        $model = $this->route('error');

        return [
            'name' => "required|string|unique:error_categories,name,{$model->id},id,deleted_at,NULL",
            'title' => 'required|string' ,
            'title_en' => 'nullable|string' ,
            'date' => 'nullable|date' ,
            'description' => 'nullable|string' ,
        ];
    }
}
