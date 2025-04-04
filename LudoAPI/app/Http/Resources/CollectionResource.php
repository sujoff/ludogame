<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'type' => $this->type,
            'cost' => $this->cost,
            'currency_type' => $this->currency_type,
            'code' => $this->code,
            'amount' => $this->amount,
            'category' => $this->category,
        ];
    }
}
