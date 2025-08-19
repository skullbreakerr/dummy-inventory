<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderHistoryResource extends JsonResource
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
            'order'=>new OrderResource($this->order),
            'order_status'=>new OrderStatusResource($this->order_status),
            'date'=>Carbon::parse($this->created_at)->format('d-m-Y')
        ];
    }
}
