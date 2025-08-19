<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'mobile'=>$this->mobile,
            'alt_mobile'=>$this->alt_mobile,
            'email'=>$this->email,
            'company'=>$this->company,
            'gst'=>$this->gst,
            'salesperson_bde'=>$this->salesperson_bde,
            'reference'=>$this->reference,
            'shopping_address'=>$this->shopping_address,
            'address'=>$this->address,
            // 'designation'=>new DesignationResource($this->designation),
            'role'=>new RoleResource($this->role),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
