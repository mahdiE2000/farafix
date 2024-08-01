<?php

namespace App\Services\Media\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'collection_name' => $this->collection_name,
            'thumbnail' => $this->getUrl('thumbnail'),
            'mime_type' => $this->mime_type,
            'file_name' => $this->file_name,
            'size' => $this->size,
        ];
    }
}
