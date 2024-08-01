<?php

namespace App\Http\Resources;

use App\Services\Media\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_en' => $this->title_en,
            'summary' => $this->summary,
            'description' => $this->description,
            'creator_id' => $this->creator_id,
            'category' => ProductCategoryResource::make($this->whenLoaded('category')),
            'creator' => UserResource::make($this->whenLoaded('creator')),
            'variations' => ProductVariationResource::collection($this->whenLoaded('variations')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'thumbnail' => $this->getFirstMediaUrl('main_image', 'thumbnail'),
            'main_image' => $this->getFirstMediaUrl('main_image'),
            'created_at' => $this->created_at,
        ];
    }
}
