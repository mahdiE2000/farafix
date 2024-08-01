<?php

    namespace App\Http\Requests\User;

    use Illuminate\Foundation\Http\FormRequest;

    class UpdateUserRequest extends FormRequest
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
                'name' => 'nullable|string|max:255' ,
                'password' => 'required|confirmed|min:6' ,
            ];
        }
    }
