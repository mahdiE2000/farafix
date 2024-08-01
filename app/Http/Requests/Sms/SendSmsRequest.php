<?php

    namespace App\Http\Requests\Sms;

    use Illuminate\Foundation\Http\FormRequest;

    class SendSmsRequest extends FormRequest
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
                'id' => 'required|numeric|exists:users,id' ,
                'content' => 'required|string' ,
            ];
        }
    }
