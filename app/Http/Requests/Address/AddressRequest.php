<?php

    namespace App\Http\Requests\Address;

    use Illuminate\Foundation\Http\FormRequest;

    class AddressRequest extends FormRequest
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
                'addresses.create' => 'nullable|array',
                'addresses.update' => 'nullable|array',
                'addresses.delete' => 'nullable|array',

                'addresses.create.*.title' => 'required|string',
                'addresses.create.*.city_id' => 'nullable|numeric',
                'addresses.create.*.district_id' => 'nullable|numeric',
                'addresses.create.*.postal_code' => 'nullable|string',

                'addresses.update.*.id' => 'required|numeric',
                'addresses.update.*.title' => 'nullable|string',
                'addresses.update.*.city_id' => 'nullable|numeric',
                'addresses.update.*.district_id' => 'nullable|numeric',
                'addresses.update.*.postal_code' => 'nullable|string',

                'addresses.delete.*' => 'required|numeric',
            ];
        }
    }
