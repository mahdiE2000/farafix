<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class AddressResource extends JsonResource
    {
        public function toArray( $request ): array
        {
            return [
                'id' => $this->id ,
                'province_id' => $this->city ? $this->city->parent_id : null ,
                'city_id' => $this->city_id ,
                'postal_code' => $this->postal_code ,
                'phone' => $this->phone ,
                'address' => $this->address ,
                'city' => CityResource::make( $this->whenLoaded( 'city' ) ) ,
            ];
        }
    }
