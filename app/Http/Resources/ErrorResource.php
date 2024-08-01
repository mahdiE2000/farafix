<?php

namespace App\Http\Resources;

use App\Http\Resources\ErrorCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Media\Resources\MediaResource;

class ErrorResource extends JsonResource
{
    public function toArray( $request ): array
    {
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'title' => $this->title ,
            'title_en' => $this->title_en ,
            'date' => $this->date ,
            'description' => $this->description ,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'error_brand' => ErrorBrandResource::make($this->whenLoaded('errorBrand')),
            'error_items' => ErrorItemResource::collection($this->whenLoaded('errorItems')),
            'error_category' => ErrorCategoryResource::make($this->whenLoaded('errorCategory')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'thumbnail' => $this->getFirstMediaUrl('main_image', 'thumbnail'),
            'main_image' => $this->getFirstMediaUrl('main_image'),
            'created_at' => $this->created_at ,
        ];
    }
}
