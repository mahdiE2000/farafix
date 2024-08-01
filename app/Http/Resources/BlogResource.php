<?php

namespace App\Http\Resources;

use App\Services\Media\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray( $request ): array
    {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'summary' => $this->summary ,
            'description' => $this->description ,
            'creator_id' => $this->creator_id ,
            'category' => BlogCategoryResource::make( $this->whenLoaded( 'category' ) ) ,
            'creator' => UserResource::make( $this->whenLoaded( 'creator' ) ) ,
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'thumbnail' => $this->getFirstMediaUrl('main_image', 'thumbnail'),
            'main_image' => $this->getFirstMediaUrl('main_image'),
            'created_at' => $this->created_at ,
        ];
    }
}
