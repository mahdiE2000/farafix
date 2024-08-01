<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    public function toArray( $request ): array
    {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'description' => $this->description ,
            'parent_id' => $this->parent_id ,
            'parent' => ProductCategoryResource::make( $this->whenLoaded( 'parent' ) ) ,
            'ancestors' => ProductCategoryResource::collection($this->whenLoaded('ancestors')),
            'children' => ProductCategoryResource::collection( $this->whenLoaded( 'children' ) ) ,
            'created_at' => $this->created_at ,
        ];
    }
}
