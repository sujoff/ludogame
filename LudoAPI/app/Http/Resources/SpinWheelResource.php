<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpinWheelResource extends JsonResource
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
            'index' => $this->index,
            'name' => $this->name,
            'is_free_spin' => $this->is_free_spin,
            'is_try_again' => $this->is_try_again,
            'collection' => $this->collection ? new CollectionResource($this->whenLoaded('collection')): null,
        ];
    }
}
