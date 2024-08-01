<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'parent' => BlogCategoryResource::make($this->whenLoaded('parent')),
            'ancestors' => BlogCategoryResource::collection($this->whenLoaded('ancestors')),
            'children' => BlogCategoryResource::collection($this->whenLoaded('children')),
            'created_at' => $this->created_at,
        ];
    }
}
