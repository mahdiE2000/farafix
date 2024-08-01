<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorCodeResource extends JsonResource
{
    public function toArray( $request ): array
    {
        return [
            'id' => $this->id ,
            'key' => $this->key ,
            'value' => $this->value ,
            'ErrorItem' => ErrorItemResource::make( $this->whenLoaded( 'ErrorItem' ) ) ,
            'created_at' => $this->created_at ,
        ];
    }
}
