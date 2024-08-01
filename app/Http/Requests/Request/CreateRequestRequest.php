<?php

    namespace App\Http\Requests\Request;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class CreateRequestRequest extends FormRequest
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
            $deviceCategoriesIds = collect( config( "devices.categories" ) )->pluck( "id" )->toArray();
            return [
                'device_title' => 'required|string' ,
                'device_category_id' => [ 'required' , 'numeric' , Rule::in( $deviceCategoriesIds ) ] ,
                'description' => 'nullable|string' ,

                'address.city_id' => 'nullable|numeric|exists:cities,id' ,
                'address.postal_code' => 'nullable|string' ,
                'address.phone' => 'nullable|string' ,
                'address.address' => 'nullable|string' ,
            ];
        }
    }
