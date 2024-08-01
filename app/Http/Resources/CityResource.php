<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class CityResource extends JsonResource
    {
        public function toArray( $request ): array
        {
            return [
                'id' => $this->id ,
                'name_fa' => $this->name_fa ,
                'name_en' => $this->name_en ,
                'cities' => CityResource::collection( $this->whenLoaded( 'cities' ) ) ,
                'province' => CityResource::make( $this->whenLoaded( 'province' ) ) ,
            ];
        }
    }
