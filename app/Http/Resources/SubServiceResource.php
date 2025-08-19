<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubServiceResource extends JsonResource
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
            'name'=>$this->name,
            'image'=>$this->image != null ? asset($this->image) : null ,
            'service'=>new ServiceResource($this->service),
            'created_at'=>$this->created_at,
            'udated_at'=>$this->updated_at
        ];
    }
}
