<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class UserResource extends JsonResource
    {
        public function toArray( $request ): array
        {
            return [
                'id' => $this->id ,
                'name' => $this->name ,
                'cell_number' => $this->cell_number ,
                'role' => $this->role ,
                'requests' => RequestResource::collection($this->whenLoaded('requests')) ,
                'requests_count' => $this->when($this->requests_count !== null, $this->requests_count),
                'verified' => $this->verified ,
                'created_at' => $this->created_at ,
            ];
        }
    }
