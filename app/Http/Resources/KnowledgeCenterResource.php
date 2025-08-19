<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KnowledgeCenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'=>$this->uuid,
            'title'=>$this->title,
            'service'=>new ServiceResource($this->service),
            'sub_service'=>new SubServiceResource($this->sub_service),
            'short_description'=>$this->short_description,
            'description'=>$this->description,
            'image'=>$this->image ? asset($this->image) : null,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
