<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_id'=>$this->order_id,
            'client'=>new UserResource($this->user),
            'technology'=>new TechnologyResource($this->technology),
            'material'=>new MaterialResource($this->material),
            'confirmation_date'=>date('d-m-Y', strtotime($this->confirmation_date)),
            'expected_delivery_date'=>date('d-m-Y', strtotime($this->expected_delivery_date)),
            'inquiry_date'=>date('d-m-Y', strtotime($this->inquiry_date)),
            'order_status'=>new OrderStatusResource($this->order_status),
            'value'=>$this->value,
            'quantity_of_parts'=>$this->quantity_of_parts,
            'finish_status'=>$this->finish_status,
            'payment_status'=>$this->payment_status,
            'length'=>$this->length,
            'width'=>$this->width,
            'height'=>$this->height,
            'description'=>$this->description,
            'shipped_date'=>$this->shipped_date,
            'files'=>OrderFilesResource::collection($this->order_files),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
