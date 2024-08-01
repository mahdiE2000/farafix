<?php

    namespace App\Http\Requests\Auth;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class RegisterRequest extends FormRequest
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
                'cell_number' => [
                    'required' ,
                    'string' ,
                    'regex:/^09[0-9]{9}$/' ,
                    Rule::unique( 'users' , 'cell_number' )->where( 'verified' , 1 )->whereNull( 'deleted_at' )
                ] ,
                'password' => 'required|confirmed|min:6' ,
            ];
        }
    }
