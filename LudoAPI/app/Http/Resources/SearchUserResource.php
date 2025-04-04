<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'external_id' => $this->external_id,
            'coin' => $this->coin,
            'gem' => $this->gem,
            'settings' => $this->settings,
            'statistics' => $this->statistics,
            'name' => $this->name,
            'firebase_id' => $this->firebase_id,
            'profile_image' => $this->profile_image,
            'is_friend' => $this->is_friend,
            'xp' => $this->xp
        ];
    }
}
