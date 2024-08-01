<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'title_en' => $this->title_en,
            'summary' => $this->summary,
            'description' => $this->description,
            'error_id' => $this->error_id,
            'error' => ErrorResource::make($this->whenLoaded('error')),
            'codes' => ErrorCodeResource::collection($this->whenLoaded('errorCodes')),
            'created_at' => $this->created_at,
        ];
    }
}
