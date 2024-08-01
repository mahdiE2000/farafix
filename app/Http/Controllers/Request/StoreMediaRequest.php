<?php

namespace App\Http\Controllers\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'batch_id' => 'required|string|size:50',
            'file' => 'required_without:url|mimes:jpeg,jpg,bmp,png,webp|max:2048',
            'url'=>'required_without:file',
            'model_name' => 'required|string',
            'collection_name' => 'required|string',
            'crop' => 'nullable|array',
            'crop.top' => 'nullable|numeric',
            'crop.left' => 'nullable|numeric',
            'crop.width' => 'nullable|numeric',
            'crop.height' => 'nullable|numeric',
        ];
    }
}
