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
            'id' => $this->id,
            'status' => $this->status,
            'table' => [
                'id' => $this->table->id,
                'number' => $this->table->number,
            ],
            'total_price' => $this->total_price,
            'opened_at' => $this->opened_at,
            'items' => OrderItemResource::collection(
                $this->whenLoaded('orderItems')
            ),
        ];
    }
}
