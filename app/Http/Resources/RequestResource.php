<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class RequestResource extends JsonResource
    {
        public function toArray( $request ): array
        {
            return [
                'id' => $this->id ,
                'device_title' => $this->device_title ,
                'device_category' => $this->device_category_id != null ? $this->device_category : null,
                'device_category_id' => $this->device_category_id ,
                'user' => UserResource::make( $this->whenLoaded( 'user' ) ) ,
                'address' => AddressResource::make( $this->whenLoaded( 'address' ) ) ,
                'addresses' => AddressResource::collection( $this->whenLoaded( 'addresses' ) ) ,
                'description' => $this->description ,
                'status' => $this->status ,
                'created_at' => $this->created_at ,
            ];
        }
    }
