<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    public function toArray( $request ): array
    {
        return [
            'id' => $this->id ,
            'key' => $this->key ,
            'value' => $this->value ,
            'product' => ProductResource::make( $this->whenLoaded( 'product' ) ) ,
            'created_at' => $this->created_at ,
        ];
    }
}
